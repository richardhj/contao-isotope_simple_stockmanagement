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
$table = Isotope\Model\ProductType::getTable();


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$table]['stockmanagement_legend'] = 'Lagerverwaltung';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['stockmanagement_active'][0] = 'Lagerverwaltung aktivieren';
$GLOBALS['TL_LANG'][$table]['stockmanagement_active'][1] = 'Aktivieren Sie die Lagerwaltung für Produkte dieses Produkttypes.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'][0] = 'Produkte deaktivieren';
$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'][1] = 'Lassen Sie die Proukte deaktivieren, sobald sie ausverkauft sind.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notification'][0] = 'Benachrichtigungen versenden';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notification'][1] = 'Lassen Sie sich Benachrichtigungen zuschicken, wenn der Lagerbestand des Produktes unter einen gewissen Schwellenwert fällt.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'][0] = 'Benachrichtigungen';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'][1] = 'Wählen Sie die Benachrichtigung aus, die verschickt werden soll und den Schwellenwert, den der Lagerbestand des Produktes erreichen muss, um die Benachrichtigung zu verschicken.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_threshold'][0] = 'Schwellenwert';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_threshold'][1] = 'Die Benachrichtigung wird verschickt, wenn der Lagerbestand diesen Schwellenwert erreicht.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_nc_id'][0] = 'Benachrichtigung';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_nc_id'][1] = 'Die Benachrichtigung, die verschickt werden soll. Werden im Benachrichtigungscenter erstellt und konfiguriert.';
