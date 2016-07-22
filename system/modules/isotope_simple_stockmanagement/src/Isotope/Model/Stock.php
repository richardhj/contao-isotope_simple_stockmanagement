<?php
/**
 * Isotope "simple stock management" for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package Isotope
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


namespace Isotope\Model;


/**
 * Class Stock
 * @property int    $tstamp
 * @property int    $pid
 * @property int    $product_collection_id
 * @property int    $quantity
 * @property int    $source
 * @property string $comment
 * @package Isotope\Model
 */
class Stock extends \Model
{

    /**
     * Stock management sources
     */
    const STOCKMANAGEMENT_SOURCE_ORDER = 'order';
    const STOCKMANAGEMENT_SOURCE_BACKEND = 'backend';
    const STOCKMANAGEMENT_SOURCE_IMPORT = 'import';


    /**
     * Name of the current table
     *
     * @var string
     */
    protected static $strTable = 'tl_iso_stock';


    /**
     * Find all stock entries for one product
     *
     * @param int $product The product's id
     *
     * @return \Model\Collection|static
     */
    public static function findForProduct($product)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return static::findBy('pid', $product);
    }


    /**
     * Get the stock of the product
     *
     * @param int $product
     *
     * @return int|false if none entries in database
     */
    public static function getStockForProduct($product)
    {
        $entries = static::findForProduct($product);

        if (null === $entries) {
            return false;
        }

        $stock = 0;

        while ($entries->next()) {
            $stock += $entries->quantity;
        }

        return $stock;
    }
}
