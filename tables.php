<?php
/**
 * Copyright Zikula Foundation 2009 - Profile module for Zikula
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/GPLv3 (or at your option, any later version).
 * @package Profile
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Returns (legacy) table information for the Profile module.
 * 
 * @return array Table/column definition array.
 */
function ContentStats_tables()
{
    
    // Initialise table array
    $dbtable = array();

    // Full table definition
    $dbtable['contentstats'] = 'contentstats';
    $dbtable['contentstats_column'] = array('pid'   => 'pid',
                                            'url'   => 'url',
                                            'name'  => 'name',
											'img'   => 'img',
                                            'sql'   => 'csql');
    $dbtable['contentstats_column_def'] = array('pid'  => 'I(10) NOTNULL AUTOINCREMENT PRIMARY',
                                                'url'  => "C(255) NOTNULL DEFAULT ''",
                                                'name' => "C(255) NOTNULL DEFAULT ''",
												'img' => "C(255) NOTNULL DEFAULT ''",
                                                'sql'  => "C(255) NOTNULL DEFAULT ''");

    // Return the table information
    return $dbtable;
}
