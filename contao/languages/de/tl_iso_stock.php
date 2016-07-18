<?php
/**
 * Isotope "simple stock management" for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package Isotope
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
 */


/** @noinspection PhpUndefinedMethodInspection */
$table = Isotope\Model\Stock::getTable();


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$table]['stock_legend'] = 'Eine neue Lagerbestandsänderung buchen';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['pid'][0] = 'Produkt';
$GLOBALS['TL_LANG'][$table]['product_collection_id'][0] = 'Bestellung';
$GLOBALS['TL_LANG'][$table]['quantity'][0] = 'Anzahl';
$GLOBALS['TL_LANG'][$table]['quantity'][1] = 'Geben Sie den Lagerbestandszugang (positive Zahl) oder die Lagerentnahme (negative Zahl) ein.';
$GLOBALS['TL_LANG'][$table]['source'][0] = 'Herkunft';
$GLOBALS['TL_LANG'][$table]['comment'][0] = 'Kommentar';
$GLOBALS['TL_LANG'][$table]['comment'][1] = 'Geben Sie einen optionalen Hinweis ein.';


/**
 * References
 */
$GLOBALS['TL_LANG'][$table]['source_options'][Isotope\Model\Stock::STOCKMANAGEMENT_SOURCE_BACKEND] = 'Backend';
$GLOBALS['TL_LANG'][$table]['source_options'][Isotope\Model\Stock::STOCKMANAGEMENT_SOURCE_ORDER] = 'Bestellung';
$GLOBALS['TL_LANG'][$table]['source_options'][Isotope\Model\Stock::STOCKMANAGEMENT_SOURCE_IMPORT] = 'Import';


/**
 * Operations
 */
$GLOBALS['TL_LANG'][$table]['show'][0] = 'Details zeigen';
$GLOBALS['TL_LANG'][$table]['show'][1] = 'Details zur Buchung ID %u zeigen';
