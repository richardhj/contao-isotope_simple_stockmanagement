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
$GLOBALS['BE_MOD']['isotope']['iso_products']['tables'][] = \Richardhj\Isotope\SimpleStockmanagement\Model\Stock::getTable();


/**
 * Models
 */
$GLOBALS['TL_MODELS'][\Richardhj\Isotope\SimpleStockmanagement\Model\Stock::getTable()] = 'Richardhj\Isotope\SimpleStockmanagement\Model\Stock';


/**
 * Hooks
 */
$GLOBALS['ISO_HOOKS']['addProductToCollection'][] = [
    \Richardhj\Isotope\SimpleStockmanagement\FrontendIntegration\Hooks::class,
    'checkBeforeAddToCollection',
];
$GLOBALS['ISO_HOOKS']['updateItemInCollection'][] = [
    \Richardhj\Isotope\SimpleStockmanagement\FrontendIntegration\Hooks::class,
    'checkBeforeUpdateCollection',
];
$GLOBALS['ISO_HOOKS']['itemIsAvailable'][] = [
    \Richardhj\Isotope\SimpleStockmanagement\FrontendIntegration\Hooks::class,
    'checkItemIsAvailable',
];
$GLOBALS['ISO_HOOKS']['preCheckout'][] = [
    \Richardhj\Isotope\SimpleStockmanagement\FrontendIntegration\Hooks::class,
    'checkBeforeCheckout',
];
$GLOBALS['ISO_HOOKS']['postCheckout'][] = [
    \Richardhj\Isotope\SimpleStockmanagement\FrontendIntegration\Hooks::class,
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
