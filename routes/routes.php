<?php

return array(
    // File upload functionality
    'file/upload' => 'upload/index',

    'break/create' => 'break/create',
    'break/read/([0-9]+)' => 'break/read/$1',
    'break/delete/([0-9]+)' => 'break/delete/$1',

    // Main Page
    'index.php' => 'index/index', // actionIndex в IndexController
    '' => 'index/index', // actionIndex в IndexController
);




