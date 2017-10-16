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


/**
 * Back end modules
 */
/** @noinspection PhpUndefinedMethodInspection */
$GLOBALS['BE_MOD']['isotope']['iso_products']['tables'][] = \Isotope\Model\Stock::getTable();


/**
 * Models
 */
/** @noinspection PhpUndefinedMethodInspection */
$GLOBALS['TL_MODELS'][Isotope\Model\Stock::getTable()] = 'Isotope\Model\Stock';


/**
 * Hooks
 */
$GLOBALS['ISO_HOOKS']['addProductToCollection'][] = [
    'Isotope\SimpleStockmanagement\Hooks',
    'checkBeforeAddToCollection',
];
$GLOBALS['ISO_HOOKS']['updateItemInCollection'][] = [
    'Isotope\SimpleStockmanagement\Hooks',
    'checkBeforeUpdateCollection',
];
$GLOBALS['ISO_HOOKS']['itemIsAvailable'][] = [
    'Isotope\SimpleStockmanagement\Hooks',
    'checkItemIsAvailable',
];
$GLOBALS['ISO_HOOKS']['preCheckout'][] = [
    'Isotope\SimpleStockmanagement\Hooks',
    'checkBeforeCheckout',
];
$GLOBALS['ISO_HOOKS']['postCheckout'][] = [
    'Isotope\SimpleStockmanagement\Hooks',
    'updateStockPostCheckout',
];


/**
 * Notification Center Notification Types
 */
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['recipients'] = [
    'admin_email',
];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_text'] = [
    'product_*',
    'order_*',
    'config_*',
];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_subject'] = &$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_text'];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_html'] = &$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_text'];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_replyTo'] = &$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['recipients'];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_recipient_cc'] = &$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['recipients'];
$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['email_recipient_bcc'] = &$GLOBALS['NOTIFICATION_CENTER']['NOTIFICATION_TYPE']['isotope']['iso_stockmanagement_change']['recipients'];
