<?php
/**
 * Isotope "simple stock management" for Contao Open Source CMS
 *
 * Copyright (c) 2016 Richard Henkenjohann
 *
 * @package Isotope
 * @author  Richard Henkenjohann <richardhenkenjohann@googlemail.com>
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
$GLOBALS['TL_DCA'][$table]['palettes']['standard'] .= ';stockmanagement_active';


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
    'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_notifications'],
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'tl_class'     => 'clr',
        'columnFields' => [
            'threshold' => [
                'inputType' => 'text',
                'eval'      => [
                    'rgxp'      => 'digit',
                    'mandatory' => true,
                ],
            ],
            'nc_id'     => [
                'inputType'        => 'select',
                'eval'             => [
                    'mandatory' => true,
                ],
                'options_callback' => function (\DataContainer $dc) {
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
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA'][$table]['fields']['stockmanagement_disableProduct'] = [
    'label'     => &$GLOBALS['TL_LANG'][$table]['stockmanagement_disableProduct'],
    'inputType' => 'checkbox',
    'eval'      => [
        'tl_class' => 'w50',
    ],
    'sql'       => "char(1) NOT NULL default ''",
];
