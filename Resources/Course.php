<?php

// All courses
$app->get('/courses', function() use($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('Courses');
  $queryHelper->usePage(PER_PAGE);
  $queryHelper->addFilter(array('param' => 'name', 'column' => 'course_name'));
  $queryHelper->addFilter('course_code');
  $queryHelper->addFilter('class_code');

  return $app->response->setJsonContent($queryHelper->result());
});

// Get course by id
$app->get('/course/{id:[0-9]+}', function($id) use ($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('Courses');
  $queryHelper->addFilter('id', QueryHelper::FILTER_SIMPLE, $id);

  return $app->response->setJsonContent($queryHelper->result());
});

