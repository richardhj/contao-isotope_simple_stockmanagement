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

namespace Richardhj\Isotope\SimpleStockManagement\BackendIntegration;


use Contao\System;
use Isotope\Model\Product;
use Richardhj\Isotope\SimpleStockManagement\Model\Stock;

class LabelCallbackListener
{
    /** @noinspection MoreThanThreeArgumentsInspection
     *
     * @param $row
     * @param $label
     * @param $dc
     * @param $args
     *
     * @return mixed
     *
     * @throws \Exception If type is not a related field of tl_iso_product
     */
    public function generate($row, $label, $dc, $args)
    {
        list (
            $callbackClass, $callbackMethod
            ) = $GLOBALS['TL_DCA']['tl_iso_product']['list']['label']['label_callback.default'];
        $args = System::importStatic($callbackClass)->{$callbackMethod}($row, $label, $dc, $args);

        $index = array_search('stock', $GLOBALS['TL_DCA']['tl_iso_product']['list']['label']['fields'], true);

        $product     = Product::findByPk($row['id']);
        $productType = $product->getRelated('type');
        if (null === $productType || !$productType->stockmanagement_active) {
            return $args;
        }

        if ($index !== false) {
            $stock = Stock::getStockForProduct($row['id']);

            if($stock === false) {
                $blnVariants = $product->hasVariants();
                if($blnVariants === true) {
                    $arrVariants = $product->getVariantIds();
                    foreach($arrVariants AS $var) {
                        $intStock = Stock::getStockForProduct($var);
                        if($intStock) {
                            $stock.= '<div class="stock"><span style="color:#999;padding-left:3px">[ID: '.$var.']</span> '.$intStock.'</div>';
                        }
                    }
                }
            }
            $args[$index] = (false !== $stock) ? $stock : 'N/A';
        }

        return $args;
    }
}
