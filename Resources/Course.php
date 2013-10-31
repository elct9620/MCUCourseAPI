<?php

// All courses
$app->get('/courses', function() use($app) {
  $page = $app->request->getQuery('page', 'int', 1);
  $startRecord = ($page - 1) * PER_PAGE;

  // Query
  $queryString = array();
  $queryData = array();
  $name = $app->request->getQuery('name');
  $courseCode = $app->request->getQuery('course_code');
  $classCode = $app->request->getQuery('class_code');

  if($name) {
    array_push($queryString, 'course_name LIKE :name:');
    $queryData['name'] = '%' . $name . '%';
  }

  if($courseCode) {
    array_push($queryString, 'course_code LIKE :courseCode:');
    $queryData['courseCode'] = '%'. $courseCode . '%';
  }

  if($classCode) {
    array_push($queryString, 'class_code LIKE :classCode:');
    $queryData['classCode'] = '%' . $classCode . '%';
  }

  if(count($queryString) > 0) {
    $queryCache = implode(" AND ", $queryString);
    $queryString = " WHERE {$queryCache}";
    unset($queryCache);
  } else {
    $queryString = "";
  }

  $phql = "SELECT * FROM Courses{$queryString} LIMIT {$startRecord}, " . PER_PAGE;
  $courses = $app->modelsManager->executeQuery($phql, $queryData);

  return $app->response->setJsonContent($courses->toArray());
});

// Get course by id
$app->get('/course/{id:[0-9]+}', function($id) use ($app) {
  $phql = "SELECT * FROM Courses WHERE id = :id:";
  $course = $app->modelsManager->executeQuery($phql, array('id' => $id));

  return $app->response->setJsonContent($course->toArray());
});

