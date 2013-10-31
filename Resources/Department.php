<?php

$app->get('/departments', function() use ($app) {
  $page = $app->request->getQuery('page', 'int', 1);
  $startRecord = ($page - 1) * PER_PAGE;

  // Query
  $queryString = array();
  $queryData = array();
  $name = $app->request->getQuery('name');

  if($name) {
    array_push($queryString, 'name LIKE :name:');
    $queryData['name'] = '%' . $name . '%';
  }

  if(count($queryString) > 0) {
    $queryCache = implode(" AND ", $queryString);
    $queryString = " WHERE {$queryCache}";
    unset($queryCache);
  } else {
    $queryString = "";
  }

  $phql = "SELECT * FROM Departments{$queryString} LIMIT {$startRecord}, " . PER_PAGE;
  $departments = $app->modelsManager->executeQuery($phql, $queryData);

  return $app->response->setJsonContent($departments->toArray());
});

$app->get('/department/{code:[0-9]+}', function($code) use ($app) {
  $phql = "SELECT * FROM Departments WHERE code = :code:";
  $department = $app->modelsManager->executeQuery($phql, array('code' => $code));

  return $app->response->setJsonContent($department->toArray());

});
