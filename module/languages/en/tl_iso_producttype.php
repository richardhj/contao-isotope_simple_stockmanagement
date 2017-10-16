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


$table = Isotope\Model\ProductType::getTable();


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$table]['stockmanagement_legend'] = 'Stock management';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['stockmanagement_active'][0]                  = 'Enable stock management';
$GLOBALS['TL_LANG'][$table]['stockmanagement_active'][1]                  = 'Enable the stock management for products of this product type.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'][0]          = 'Disable products';
$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'][1]          = 'Disable the products if getting sold out.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notification'][0]            = 'Enable notifications';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notification'][1]            = 'Send notifications if the stock reaches a certain quantity.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'][0]           = 'Notifications';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'][1]           = 'Choose the notifications to send plus the threshold which is required to trigger this notification.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_threshold'][0] = 'Threshold';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_threshold'][1] = 'The notification gets triggered when the stock reaches this threshold.';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_nc_id'][0]     = 'Notification';
$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_nc_id'][1]     = 'The notification to send. They are configurable via the notification center.';
