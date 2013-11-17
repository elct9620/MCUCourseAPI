<?php

/**
 * Helper
 */
require_once 'Helper/Helper.php';
require_once 'Helper/QueryHelper.php';

$di = new \Phalcon\DI\FactoryDefault();

$di->set('db', function () {
    return new \Phalcon\Db\Adapter\Pdo\Sqlite(array(
        'dbname' => 'database.sqlite'
    ));
});

$di->set('response', function () {
    return new \Phalcon\Http\Response();
});

$di->set('queryHelper', 'MCUCourseAPI\Helper\QueryHelper');

return $di;
