<?php

return new \Phalcon\Config(array(
    'database'    => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'user',
        'password' => '123',
        'dbname'   => 'datatables',
        'options'  => [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM,
        ]
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/phadable/',
    )
));
