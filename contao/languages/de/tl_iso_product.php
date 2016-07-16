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
$table = Isotope\Model\Product::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['stock'][0] = 'Lagerbestand';
$GLOBALS['TL_LANG'][$table]['stock'][1] = 'Übersicht über die Ein- und Ausgänge des Lagerbestands von diesem Produkt.';


/**
 * Operations
 */
$GLOBALS['TL_LANG'][$table]['stock_create_button'] = 'Neue Buchung erstellen';
