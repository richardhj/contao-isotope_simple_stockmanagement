<?php

/**
 * This file is part of richardhj/contao-isotope_simple_stockmanagement.
 *
 * Copyright (c) 2016-2018 Richard Henkenjohann
 *
 * @package   richardhj/contao-isotope_simple_stockmanagement
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2018 Richard Henkenjohann
 * @license   https://github.com/richardhj/contao-isotope_simple_stockmanagement/blob/master/LICENSE LGPL-3.0
 */


namespace Richardhj\Isotope\SimpleStockManagement\FrontendIntegration;

use Contao\Controller;
use Contao\Database;
use Contao\Model;
use Contao\PageModel;
use Contao\System;
use Isotope\Message;
use Isotope\Model\Product;
use Isotope\Model\ProductCollection;
use Isotope\Model\ProductCollectionItem;
use Isotope\Module\Checkout;
use NotificationCenter\Model\Notification;
use Richardhj\Isotope\SimpleStockManagement\Model\Stock;


/**
 * Class Hooks
 *
 * @package Isotope\SimpleStockmanagement
 */
class Hooks
{

    /**
     * @category ISO_HOOKS: addProductToCollection
     *
     * @param Product|Model     $product
     * @param int               $quantity
     * @param ProductCollection $collection
     *
     * @return int
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function checkBeforeAddToCollection(Product $product, $quantity, ProductCollection $collection)
    {
        $productType = $product->getRelated('type');
        if (null === $productType || !$productType->stockmanagement_active) {
            return $quantity;
        }

        $quantityInCart = 0;
        $stock          = Stock::getStockForProduct($product->id);

        foreach ((array)$collection->getItems() as $item) {
            if ($item->product_id === $product->id) {
                $quantityInCart += $item->quantity;
            }
        }

        if (false === $stock) {
            return $quantity;
        }
        if (0 === $stock) {
            Message::addError($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['productUnavailable']);

            return 0;

        }
        if ($quantity + $quantityInCart > $stock) {
            Message::addInfo($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['maxQuantityAdded']);

            return $stock - $quantityInCart;
        }

        return $quantity;
    }


    /**
     * @category ISO_HOOKS: updateItemInCollection
     *
     * @param ProductCollectionItem|Model $item
     * @param array                       $set
     *
     * @return array
     * @internal param ProductCollection $collection
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function checkBeforeUpdateCollection(ProductCollectionItem $item, $set)
    {
        if (empty($set['quantity'])) {
            return $set;
        }

        /** @var Product|Model $product */
        $product     = $item->getProduct();
        $productType = $product->getRelated('type');

        if (null === $productType || !$productType->stockmanagement_active) {
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
     * @param ProductCollectionItem|Model $item
     *
     * @return false|null Return false but never true
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function checkItemIsAvailable(ProductCollectionItem $item)
    {
        /** @var Product|Model $product */
        $product     = $item->getProduct();
        $productType = $product->getRelated('type');

        if (null === $productType || !$productType->stockmanagement_active) {
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
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function checkBeforeCheckout(ProductCollection\Order $order, Checkout $checkout)
    {
        foreach ($order->getItems() as $item) {
            /** @var Product|Model $product */
            $product     = $item->getProduct();
            $productType = $product->getRelated('type');
            $stock       = Stock::getStockForProduct($product->id);

            if (null !== $productType
                && ($productType->stockmanagement_active && false !== $stock
                    && $item->quantity > $stock)) {
                Message::addError($GLOBALS['TL_LANG']['MSC']['simpleStockmanagement']['productQuantityUnavailable']);

                if ($checkout->iso_cart_jumpTo > 0) {
                    /** @type PageModel $jumpTo */
                    $jumpTo = PageModel::findPublishedById($checkout->iso_cart_jumpTo);

                    if (null !== $jumpTo) {
                        $jumpTo->loadDetails();
                        Controller::redirect($jumpTo->getFrontendUrl(null, $jumpTo->language));
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
     *
     * @internal param array $tokens
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function updateStockPostCheckout(ProductCollection\Order $order)
    {
        foreach ($order->getItems() as $item) {
            /** @var Product|Model $product */
            $product     = $item->getProduct();
            $productType = $product->getRelated('type');

            if (null !== $productType && $productType->stockmanagement_active) {
                // Book stock change
                /** @var Stock|Model $stockChange */
                $stockChange                        = new Stock();
                $stockChange->tstamp                = time();
                $stockChange->pid                   = $product->id;
                $stockChange->product_collection_id = $order->id;
                $stockChange->quantity              = -1 * (int)$item->quantity;
                $stockChange->source                = Stock::STOCKMANAGEMENT_SOURCE_ORDER;
                $stockChange->save();

                // Fetch current stock
                $stock = Stock::getStockForProduct($product->id);

                // Disable product if necessary
                if ($productType->stockmanagement_disableProduct && false !== $stock && $stock < 1) {
                    // Do not use the model to persist. See #2
                    Database::getInstance()
                        ->prepare("UPDATE {$product::getTable()} SET published='' WHERE id=?")
                        ->execute($product->id);
                }

                // Send stock change notifications
                if ($productType->stockmanagement_notification) {
                    if (false === $stock) {
                        System::log(
                            'Product ID '.$product->id.' haven\'t stocked up yet. Please set initial stock.',
                            __METHOD__,
                            TL_GENERAL
                        );

                        return;
                    }

                    $notifications = deserialize($productType->stockmanagement_notifications);

                    foreach ($notifications as $notification) {
                        if ($stock <= $notification['threshold']) {
                            /** @noinspection PhpUndefinedMethodInspection */
                            /** @var Notification $notificationCenter */
                            $notificationCenter = Notification::findByPk($notification['nc_id']);

                            if (null !== $notificationCenter) {
                                $notificationCenter->send(self::createStockChangeNotificationTokens($product, $order));
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
     * @param Product|Model                 $product
     * @param ProductCollection\Order|Model $order
     *
     * @return array
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    private static function createStockChangeNotificationTokens(Product $product, ProductCollection\Order $order)
    {
        $tokens = [];

        $tokens['admin_email'] = $GLOBALS['TL_ADMIN_EMAIL'];

        $config = $order->getRelated('config_id');

        foreach ($product->row() as $k => $v) {
            $tokens['product_'.$k] = $v;
        }

        foreach ($order->row() as $k => $v) {
            $tokens['order_'.$k] = $v;
        }

        if (null !== $config) {
            foreach ((array)$config->row() as $k => $v) {
                $tokens['config_'.$k] = $v;
            }
        }

        return $tokens;
    }
}
