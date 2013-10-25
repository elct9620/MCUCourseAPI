<?php

$di = require('di.php');
$loader = new \Phalcon\Loader();
$loader->registerDirs(
  array(
    __DIR__ . '/models/'
  )
)->register();

$app = new \Phalcon\Mvc\Micro($di);
$app->response->setHeader('Content-Type', 'application/json,text/json');

// Routers

$app->get('/', function() use ($app) {
  return $app->response->setJsonContent(
    array(
      'api' => array(
        'version' => '0.1'
      )
    )
  );
});

$app->get('/api/courses', function() use($app) {
  $page = $app->request->getQuery('page', null, 1);
  $startRecord = ($page - 1) * 25;
  $phql = "SELECT * FROM Courses LIMIT {$startRecord}, 25";
  $courses = $app->modelsManager->executeQuery($phql);

  return $app->response->setJsonContent($courses->toArray());
});

$app->get('/api/courses/{name}', function($name) use ($app) {
  $page = $app->request->getQuery('page', null, 1);
  $startRecord = ($page - 1) * 25;
  $phql = "SELECT * FROM Courses WHERE course_name LIKE :name: LIMIT {$startRecord}, 25";
  $courses = $app->modelsManager->executeQuery($phql, array('name' => '%' . $name . '%'));

  return $app->response->setJsonContent($courses->toArray());
});

$app->handle();
