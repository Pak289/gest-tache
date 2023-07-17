<?php

function connection(): PDO
{
    $db_parameters = array (
        'dbhost' => 'localhost',
        'dbname' => 'stm_v010',
        'dbuser' => 'stm',
        'dbpass' => 'stm*stm67'
    );
    return new PDO('mysql:host='.array_values($db_parameters)[0].';dbname='.array_values($db_parameters)[1],array_values($db_parameters)[2],array_values($db_parameters)[3]);
}
