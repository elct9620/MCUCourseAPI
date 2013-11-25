<?php

require "config.php";

// Initialize Dependency Injection
$di = require 'DI.php';

// Initialize Phalcon Loader to load class
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    array(
        "MCUCourseAPI\Models" => __DIR__ . '/Models/'
    )
)->register();

// Initialize Phalcon Mirco Framework
$app = new \Phalcon\Mvc\Micro($di);
$app->response->setHeader('Access-Control-Allow-Origin', '*');
$app->response->setHeader('Content-Type', 'application/json,text/json'); // All data response to json

// Routers

include_once(RESOURCE_PATH . "/Home.php");
include_once(RESOURCE_PATH . "/Department.php");
include_once(RESOURCE_PATH . "/Course.php");
include_once(RESOURCE_PATH . "/Teacher.php");
include_once(RESOURCE_PATH . "/CourseTime.php");

/**
 * Notfoun Handler
 */

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    $app->response->setJsonContent(
        array(
            'error' => array(
                'code' => '404',
                'message' => 'Not found.'
            )
        )
    )->send();
});

$app->handle();
