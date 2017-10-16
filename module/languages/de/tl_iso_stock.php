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
$GLOBALS['TL_LANG'][$table]['stock_legend'] = 'Eine neue Lagerbestandsänderung buchen';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['pid'][0]                   = 'Produkt';
$GLOBALS['TL_LANG'][$table]['product_collection_id'][0] = 'Bestellung';
$GLOBALS['TL_LANG'][$table]['quantity'][0]              = 'Anzahl';
$GLOBALS['TL_LANG'][$table]['quantity'][1]              = 'Geben Sie den Lagerbestandszugang (positive Zahl) oder die Lagerentnahme (negative Zahl) ein.';
$GLOBALS['TL_LANG'][$table]['source'][0]                = 'Herkunft';
$GLOBALS['TL_LANG'][$table]['comment'][0]               = 'Kommentar';
$GLOBALS['TL_LANG'][$table]['comment'][1]               = 'Geben Sie einen optionalen Hinweis ein.';


/**
 * References
 */
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_BACKEND] = 'Backend';
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_ORDER]   = 'Bestellung';
$GLOBALS['TL_LANG'][$table]['source_options'][Richardhj\Isotope\SimpleStockManagement\Model\Stock::STOCKMANAGEMENT_SOURCE_IMPORT]  = 'Import';


/**
 * Operations
 */
$GLOBALS['TL_LANG'][$table]['show'][0] = 'Details zeigen';
$GLOBALS['TL_LANG'][$table]['show'][1] = 'Details zur Buchung ID %u zeigen';
