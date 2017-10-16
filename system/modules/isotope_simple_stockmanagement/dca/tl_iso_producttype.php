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


use Isotope\Model\ProductType;
use NotificationCenter\Model\Notification;


/** @noinspection PhpUndefinedMethodInspection */
$table = ProductType::getTable();


/**
 * Palettes
 */
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'stockmanagement_active';
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'stockmanagement_notification';
$GLOBALS['TL_DCA'][$table]['palettes']['standard'] .= ';{stockmanagement_legend},stockmanagement_active';


/**
 * SubPalettes
 */
$GLOBALS['TL_DCA'][$table]['subpalettes']['stockmanagement_active'] = 'stockmanagement_disableProduct,stockmanagement_notification';
$GLOBALS['TL_DCA'][$table]['subpalettes']['stockmanagement_notification'] = 'stockmanagement_notifications';


/**
 * Fields
 */
$GLOBALS['TL_DCA'][$table]['fields']['stockmanagement_active'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_active'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class'       => 'w50',
        'submitOnChange' => true,
    ],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['stockmanagement_notification'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_notification'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class'       => 'w50',
        'submitOnChange' => true,
    ],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$table]['fields']['stockmanagement_notifications'] = [
    'label'         => &$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'],
    'inputType'     => 'multiColumnWizard',
    'eval'          => [
        'tl_class'     => 'clr',
        'columnFields' => [
            'threshold' => [
                'inputType' => 'text',
                'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_threshold'],
                'eval'      => [
                    'rgxp'      => 'digit',
                    'mandatory' => true,
                    'style'     => 'width:60px;text-align:right',
                ],
            ],
            'nc_id'     => [
                'inputType'        => 'select',
                'label'            => &$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications_nc_id'],
                'eval'             => [
                    'mandatory' => true,
                ],
                'options_callback' => function () {
                    /** @var Notification|\Model\Collection $notifications */
                    /** @noinspection PhpUndefinedMethodInspection */
                    $notifications = Notification::findBy('type', 'iso_stockmanagement_change');

                    if (null === $notifications) {
                        return [];
                    }

                    return $notifications->fetchEach('title');
                },
            ],
        ],
        'buttons'      => ['up' => false, 'down' => false],
    ],
    'save_callback' => [
        // Sort by threshold ascending
        function ($value) {
            $value = deserialize($value);

            $thresholds = array_reduce(
                $value,
                function ($carry, $item) {
                    return array_merge($carry, [$item['threshold']]);
                },
                []
            );

            array_multisort($thresholds, SORT_NUMERIC, $value);

            return serialize($value);
        },
    ],
    'sql'           => "text NULL",
];

$GLOBALS['TL_DCA'][$table]['fields']['stockmanagement_disableProduct'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'w50',
    ],
    'sql'       => "char(1) NOT NULL default ''",
];
