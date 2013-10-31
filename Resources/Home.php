<?php

// API Home Page

$app->get('/', function() use ($app) {
  return $app->response->setJsonContent(
    array(
      'api' => array(
        'version' => '0.1',
        'last_update' => '2013-10-31'
      )
    )
  );
});


