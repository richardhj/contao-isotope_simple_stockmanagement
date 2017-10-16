<?php

/**
 * This file is part of richardhj/contao-isotope_simple_stockmanagement.
 *
 * Copyright (c) 2016-2017 Richard Henkenjohann
 *
 * @package   richardhj/contao-isotope_simple_stockmanagement
 * @author    Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 * @copyright 2016-2017 Richard Henkenjohann
 * @license   https://github.com/richardhj/richardhj/contao-isotope_simple_stockmanagement/blob/master/LICENSE LGPL-3.0
 */


namespace Richardhj\Isotope\SimpleStockmanagement\BackendIntegration;

use DOMDocument;
use Contao\BackendTemplate;
use Contao\Image;
use Contao\System;
use Richardhj\Isotope\SimpleStockmanagement\Model\Stock;


/**
 * Class Dca
 * @package Isotope\SimpleStockmanagement
 */
class Dca
{

    /**
     * @param \Database_Result $records
     * @param string           $id
     * @param \DcaWizard       $dcaWizard
     *
     * @return string
     */
    public function generateWizardList($records, $id, $dcaWizard)
    {
        $return = '';
        $rows = $dcaWizard->getRows($records);

        // Alter the rows
        System::loadLanguageFile('tl_iso_product_collection');
        $rows = array_map(
            function ($row) {
                // Force an algebraic sign for quantity
                $row['quantity'] = sprintf('%+d', $row['quantity']);

                // Make referenced product collection editable in a popup
                $row['product_collection_id'] = ($row['product_collection_id']) ? sprintf(
                    '<a href="contao/main.php?do=iso_orders&amp;act=edit&amp;id=%1$u&amp;popup=1&amp;nb=1&amp;rt=%4$s" title="%3$s" onclick="Backend.openModalIframe({\'width\':768,\'title\':\'%3$s\',\'url\':this.href});return false">%2$s</a>',
                    // Collection ID
                    $row['product_collection_id'],
                    // Link
                    Image::getHtml('edit.gif').$row['product_collection_id'],
                    // Collection edit description
                    sprintf($GLOBALS['TL_LANG']['tl_iso_product_collection']['edit'][1], $row['product_collection_id']),
                    REQUEST_TOKEN
                ) : '-';

                return $row;
            },
            $rows
        );

        if ($rows) {
            $template = new BackendTemplate('be_widget_dcawizard');
            $template->headerFields = $dcaWizard->getHeaderFields();
            $template->hasRows = !empty($rows);
            $template->rows = $rows;
            $template->fields = $dcaWizard->fields;
            $template->showOperations = $dcaWizard->showOperations;

            if ($dcaWizard->showOperations) {
                $template->operations = $dcaWizard->getActiveRowOperations();
            }

            $template->generateOperation = function ($operation, $row) use ($dcaWizard) {
                return $dcaWizard->generateRowOperation($operation, $row);
            };

            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->loadHTML($template->parse());
            $return = $dom->saveHTML($dom->getElementsByTagName('table')->item(0));
        }

        // Add the member's total bonus points
        $return .= sprintf(
            '<strong style="display: inline-block; margin: 4px 0 2px 6px; border-bottom: 3px double">%s</strong>',
            Stock::getStockForProduct($dcaWizard->currentRecord)
        );

        return $return;
    }
}
