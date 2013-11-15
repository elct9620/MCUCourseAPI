<?php

$app->get('/teachers', function() use ($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('Teachers');
  $queryHelper->addFilter(array('param' => 'name', 'column' => 'teacher'));
  $queryHelper->usePage(PER_PAGE);

  return $app->response->setJsonContent($queryHelper->result());
});

$app->get('/teacher/{name}', function($name) use ($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('Teachers');
  $queryHelper->addFilter(array('param' => 'name', 'column' => 'teacher'), QueryHelper::FILTER_SIMPLE, $name);

  return $app->response->setJsonContent($queryHelper->result());
});