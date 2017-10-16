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


$table = Richardhj\Isotope\SimpleStockManagement\Model\Stock::getTable();


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$table]['stock_legend'] = 'Create a new stock change';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['pid'][0]                   = 'Product';
$GLOBALS['TL_LANG'][$table]['product_collection_id'][0] = 'Order';
$GLOBALS['TL_LANG'][$table]['quantity'][0]              = 'Quantity';
$GLOBALS['TL_LANG'][$table]['quantity'][1]              = 'Enter the income of stock (positive number) or the outcome of stock (negative number).';
$GLOBALS['TL_LANG'][$table]['source'][0]                = 'Source';
$GLOBALS['TL_LANG'][$table]['comment'][0]               = 'Comment';
$GLOBALS['TL_LANG'][$table]['comment'][1]               = 'Enter a comment optionally.';


/**
 * References
 */
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_BACKEND] = 'Backend';
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_ORDER]   = 'Order';
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_IMPORT]  = 'Import';


/**
 * Operations
 */
$GLOBALS['TL_LANG'][$table]['show'][0] = 'Show details';
$GLOBALS['TL_LANG'][$table]['show'][1] = 'Show details of order ID %u';
