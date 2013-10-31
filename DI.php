<?php

$di = new \Phalcon\DI\FactoryDefault();

$di->set('db', function() {
  return new \Phalcon\Db\Adapter\Pdo\Sqlite(array(
    'dbname' => 'database.sqlite'
  ));
});

$di->set('response', function() {
  return new \Phalcon\Http\Response();
});

return $di;
