<?php

return array(

    // For steering control system
    'steering-control/get/([0-9]+)' => 'steering/get/$1',
    'steering-control/get/' => 'steering/get',
    'steering-control/create' => 'steering/create',
    'steering-control/сhange' => 'steering/change',
    'steering-control/delete/([a-z]+)' => 'steering/delete/$1',

    // For Information system
    'information/get' => 'information/get',
    'information/create' => 'information/create',
    'information/delete/([0-9]+)' => 'information/delete/$1',
    'information/check/([0-9]+)' => 'information/check/$1',
    'information/errors/([0-9]+)' => 'information/errors/$1',

    // For GPS system
    'gps/get' => 'gps/get',
    'gps/create/([0-9]+)' => 'gps/create/$1',
    'gps/delete/([0-9]+)' => 'gps/delete/$1',

    // For break system
    'break/get' => 'break/get',
    'break/create' => 'break/create',
    'break/delete/([0-9]+)' => 'break/delete/$1',

    // Migration for system
    'migration/up' => 'migration/up',
    'migration/down' => 'migration/down',

    // Need for test
    'index.php' => 'index/index', // actionIndex в IndexController
    '' => 'index/index', // actionIndex в IndexController
);




