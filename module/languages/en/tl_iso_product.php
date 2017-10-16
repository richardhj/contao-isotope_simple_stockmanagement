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


$table = Isotope\Model\Product::getTable();


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$table]['stock'][0] = 'Stock';
$GLOBALS['TL_LANG'][$table]['stock'][1] = 'Overview of in- and outcomings of the product\'s stock.';


/**
 * Operations
 */
$GLOBALS['TL_LANG'][$table]['stock_create_button'] = 'Create new stock change';
