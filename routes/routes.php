<?php

return array(
    // File upload functionality
    'file/upload' => 'upload/index',

    // About books
    'book/create' => 'book/create',
    'book/read/([0-9]+)' => 'book/read/$1',
    'book/delete/([0-9]+)' => 'book/delete/$1',

    // Main Page
    'index.php' => 'book/index', // actionIndex в BookController
    '' => 'book/index', // actionIndex в BookController
);
