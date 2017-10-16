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


/** @noinspection PhpUndefinedMethodInspection */
$table = Isotope\Model\Stock::getTable();


/**
 * DCA
 */
/** @noinspection PhpUndefinedMethodInspection */
$GLOBALS['TL_DCA'][$table] = [

    // Config
    'config'   => [
        'dataContainer'    => 'Table',
        'ptable'           => Isotope\Model\Product::getTable(),
        'notDeletable'     => true,
        'notCopyable'      => true,
        'doNotCopyRecords' => true,
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],

    // List
    'list'     => [
        'sorting' => [
            'mode'   => 2,
            'fields' => ['tstamp ASC'],
            'flag'   => 1,
        ],
        'label'   => [
            'fields'      => ['pid', 'quantity', 'comment'],
            'showColumns' => true,
        ],

        'operations' => [
            'show' => [
                'label' => &$GLOBALS['TL_LANG'][$table]['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        'default' => '{stock_legend},quantity,comment',
    ],

    // Fields
    'fields'   => [
        'id'                    => [
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ],
        'tstamp'                => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'pid'                   => [
            'label'    => &$GLOBALS['TL_LANG'][$table]['pid'],
            'sql'      => "int(10) unsigned NOT NULL default '0'",
            'relation' => [
                'type'  => 'belongsTo',
                'table' => Isotope\Model\Product::getTable(),
            ],
        ],
        'product_collection_id' => [
            'label'    => &$GLOBALS['TL_LANG'][$table]['product_collection_id'],
            'relation' => [
                'type'  => 'belongsTo',
                'table' => Isotope\Model\ProductCollection::getTable(),
            ],
            'sql'      => "int(10) unsigned NOT NULL default '0'",
        ],
        'quantity'              => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['quantity'],
            'inputType' => 'text',
            'eval'      => [
                'rgxp'     => 'digit',
                'tl_class' => 'w50',
            ],
            'sql'       => "int(10) NOT NULL default '0'",
        ],
        'source'                => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['source'],
            'inputType' => 'select',
            'default'   => Isotope\Model\Stock::STOCKMANAGEMENT_SOURCE_BACKEND,
            'reference' => &$GLOBALS['TL_LANG'][$table]['source_options'],
            'sql'       => "varchar(64) NOT NULL default ''",
        ],
        'comment'               => [
            'label'     => &$GLOBALS['TL_LANG'][$table]['comment'],
            'inputType' => 'text',
            'sql'       => "varchar(255) NOT NULL default ''",
            'eval'      => [
                'tl_class' => 'w50',
            ],
        ],
    ],
];
