<?php

// All courses
$app->get('/courses', function () use ($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('MCUCourseAPI\Models\Courses');
  $queryHelper->usePage(PER_PAGE);
  $queryHelper->addFilter(array('param' => 'name', 'column' => 'course_name'));
  $queryHelper->addFilter('course_code');
  $queryHelper->addFilter('class_code');

  return $app->response->setJsonContent($queryHelper->result());
});

// Get course by id
$app->get('/course/{class_code:[0-9]+}', function ($classCode) use ($app) {
  $queryHelper = $app->queryHelper;
  $queryHelper->setModel('MCUCourseAPI\Models\Courses');
  $queryHelper->addFilter('class_code', MCUCourseAPI\QueryHelper::FILTER_SIMPLE, $classCode);

  return $app->response->setJsonContent($queryHelper->result());
});
