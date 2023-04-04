<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'presensi';

// Table's primary key
$primaryKey = 'id_loc';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        'db'        => 'date_stamp',
        'dt'        => 0,
        'formatter' => function ($d, $row) {
            return date('j/n/Y', strtotime($d));
        }
    ),
    array('db' => 'waktu',         'dt' => 1),
    array('db' => 'latitude',      'dt' => 2),
    array('db' => 'longitude',     'dt' => 3),
    array('db' => 'ip_addr',       'dt' => 4),
    array('db' => 'browser',       'dt' => 5),
    array('db' => 'os',            'dt' => 6),
    array('db' => 'device_name',   'dt' => 7)
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'sim',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('datatables/ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
