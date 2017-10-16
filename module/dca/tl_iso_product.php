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


$table = Isotope\Model\Product::getTable();


/**
 * Fields
 */
$GLOBALS['TL_DCA'][$table]['fields']['stock'] = [
    'label'        => &$GLOBALS['TL_LANG'][$table]['stock'],
    'inputType'    => 'dcaWizard',
    'foreignTable' => Richardhj\Isotope\SimpleStockManagement\Model\Stock::getTable(),
    'params'       => [
        'mode' => 2,
        'pid'  => Contao\Input::get('id'),
        'act'  => 'create',
    ],
    'eval'         => [
        'fields'          => ['quantity', 'source', 'product_collection_id', 'comment', 'tstamp'],
        'editButtonLabel' => $GLOBALS['TL_LANG'][$table]['stock_create_button'],
        'orderField'      => 'tstamp ASC',
        'showOperations'  => true,
        'operations'      => ['show'],
        'listCallback'    => [Richardhj\Isotope\SimpleStockManagement\BackendIntegration\Dca::class, 'generateWizardList'],
        'tl_class'        => 'clr',
    ],
    'attributes' => [
        'legend' => 'inventory_legend',
    ],
];
