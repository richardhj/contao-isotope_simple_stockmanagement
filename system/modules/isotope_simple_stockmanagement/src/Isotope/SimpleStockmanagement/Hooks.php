<?php
/**
 * Isotope "simple stock management" for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package Isotope
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Isotope\SimpleStockmanagement;

use Isotope\Message;
use Isotope\Model\Config;
use Isotope\Model\Product;
use Isotope\Model\ProductCollection;
use Isotope\Model\ProductCollectionItem;
use Isotope\Model\ProductType;
use Isotope\Model\Stock;
use Isotope\Module\Checkout;
use NotificationCenter\Model\Notification;


/**
 * Class Hooks
 * @package Isotope\SimpleStockmanagement
 */
class Hooks
{

    /**
     * @category ISO_HOOKS: addProductToCollection
     *
     * @param Product|\Model    $product
     * @param int               $quantity
     * @param ProductCollection $collection
     *
     * @return int
     */
    public function checkBeforeAddToCollection(Product $product, $quantity, ProductCollection $collection)
    {
        /** @var ProductType|\Model $productType */
        $productType = $product->getRelated('type');

        if (!$productType->stockmanagement_active) {
            return $quantity;
        }

        $stock = Stock::getStockForProduct($product->id);
        $quantityInCart = 0;

        foreach ($collection->getItems() as $item) {
            if ($item->product_id === $product->id) {
                $quantityInCart += $item->quantity;
            }
        }

        if (false === $stock) {
            return $quantity;
        }
        elseif (0 === $stock) {
            Message::addError($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['productUnavailable']);

            return 0;

        } elseif ($quantity + $quantityInCart > $stock) {
            Message::addInfo($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['maxQuantityAdded']);

            return $stock - $quantityInCart;
        }

        return $quantity;
    }


    /**
     * @category ISO_HOOKS: updateItemInCollection
     *
     * @param ProductCollectionItem|\Model $item
     * @param array                        $set
     * @param ProductCollection            $collection
     *
     * @return array
     *
     */
    public function checkBeforeUpdateCollection(ProductCollectionItem $item, $set, ProductCollection $collection)
    {
        if (empty($set['quantity'])) {
            return $set;
        }

        /** @var Product|\Model $product */
        $product = $item->getProduct();
        /** @var ProductType|\Model $productType */
        $productType = $product->getRelated('type');

        if (!$productType->stockmanagement_active) {
            return $set;
        }

        $stock = Stock::getStockForProduct($product->id);

        if (false !== $stock && $set['quantity'] > $stock) {
            Message::addInfo($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['maxQuantityUpdated']);

            $set['quantity'] = $stock;
        }

        return $set;
    }


    /**
     * @category ISO_HOOKS: itemIsAvailable
     *
     * @param ProductCollectionItem|\Model $item
     *
     * @return false|null Return false but never true
     */
    public function checkItemIsAvailable(ProductCollectionItem $item)
    {
        /** @var Product|\Model $product */
        $product = $item->getProduct();
        /** @var ProductType|\Model $productType */
        $productType = $product->getRelated('type');

        if (!$productType->stockmanagement_active) {
            return null;
        }

        $stock = Stock::getStockForProduct($product->id);

        if (false !== $stock && $stock < 1) {
            return false;
        }

        return null;
    }


    /**
     * @category ISO_HOOKS: preCheckout
     *
     * @param ProductCollection\Order $order
     * @param Checkout                $checkout
     *
     * @return bool
     */
    public function checkBeforeCheckout(ProductCollection\Order $order, Checkout $checkout)
    {
        foreach ($order->getItems() as $item) {
            /** @var Product|\Model $product */
            $product = $item->getProduct();
            $productType = $product->getRelated('type');
            $stock = Stock::getStockForProduct($product->id);

            if ($productType->stockmanagement_active && false !== $stock && $item->quantity > $stock) {
                Message::addError($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['productQuantityUnavailable']);

                if ($checkout->iso_cart_jumpTo > 0) {

                    /** @type \PageModel $jumpTo */
                    $jumpTo = \PageModel::findPublishedById($checkout->iso_cart_jumpTo);

                    if (null !== $jumpTo) {
                        $jumpTo->loadDetails();
                        \Controller::redirect($jumpTo->getFrontendUrl(null, $jumpTo->language));
                    }
                }

                return false;
            }
        }

        return true;
    }


    /**
     * @category ISO_HOOKS: postCheckout
     *
     * @param ProductCollection\Order $order
     * @param array                   $tokens
     *
     */
    public function updateStockPostCheckout(ProductCollection\Order $order, array $tokens)
    {
        foreach ($order->getItems() as $item) {
            /** @var Product|\Model $product */
            $product = $item->getProduct();
            $productType = $product->getRelated('type');

            if ($productType->stockmanagement_active) {
                // Book stock change
                /** @var Stock|\Model $stockChange */
                $stockChange = new Stock();
                $stockChange->tstamp = time();
                $stockChange->pid = $product->id;
                $stockChange->product_collection_id = $order->id;
                $stockChange->quantity = -1 * (int)$item->quantity;
                $stockChange->source = Stock::STOCKMANAGEMENT_SOURCE_ORDER;
                $stockChange->save();

                // Fetch current stock
                $stock = Stock::getStockForProduct($product->id);

                // Disable product if necessary
                if ($productType->stockmanagement_disableProduct && false !== $stock && $stock < 1) {
                    $product->published = '';
                    $product->save();
                }

                // Send stock change notifications
                if ($productType->stockmanagement_notification) {
                    $notifications = deserialize($productType->stockmanagement_notifications);

                    foreach ($notifications as $notification) {
                        if ($stock <= $notification['threshold']) {
                            /** @noinspection PhpUndefinedMethodInspection */
                            /** @var Notification $notificationCenter */
                            $notificationCenter = Notification::findByPk($notification['nc_id']);

                            if (null !== $notificationCenter) {
                                $notificationCenter->send(self::createStockChangeNotifictionTokens($product, $order));
                            }

                            // Do not send multiple notifications
                            break;
                        }
                    }
                }
            }
        }
    }


    /**
     * @param Product|\Model                 $product
     * @param ProductCollection\Order|\Model $order
     *
     * @return array
     */
    private static function createStockChangeNotifictionTokens(Product $product, ProductCollection\Order $order)
    {
        $tokens = [];
        $tokens['admin_email'] = $GLOBALS['TL_ADMIN_EMAIL'];

        /** @var Config|\Model $config */
        $config = $order->getRelated('config_id');

        foreach ($product->row() as $k => $v) {
            $tokens['product_'.$k] = $v;
        }

        foreach ($order->row() as $k => $v) {
            $tokens['order_'.$k] = $v;
        }

        foreach ($config->row() as $k => $v) {
            $tokens['config_'.$k] = $v;
        }

        return $tokens;
    }
}
