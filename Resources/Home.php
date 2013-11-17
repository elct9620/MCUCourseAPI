<?php

// API Home Page

$app->get('/', function () use ($app) {
  return $app->response->setJsonContent(
    array(
      'api' => array(
        'version' => VERSION,
        'last_update' => LAST_UPDATE
      )
    )
  );
});
