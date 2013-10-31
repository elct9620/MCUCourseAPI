<?php

$app->get('/courses', function() use($app) {
  $page = $app->request->getQuery('page', null, 1);
  $startRecord = ($page - 1) * PER_PAGE;
  $phql = "SELECT * FROM Courses LIMIT {$startRecord}, " . PER_PAGE;
  $courses = $app->modelsManager->executeQuery($phql);

  return $app->response->setJsonContent($courses->toArray());
});

$app->get('/courses/{name}', function($name) use ($app) {
  $page = $app->request->getQuery('page', null, 1);
  $startRecord = ($page - 1) * PER_PAGE;
  $phql = "SELECT * FROM Courses WHERE course_name LIKE :name: LIMIT {$startRecord}, " . PER_PAGE;
  $courses = $app->modelsManager->executeQuery($phql, array('name' => '%' . $name . '%'));

  return $app->response->setJsonContent($courses->toArray());
});

