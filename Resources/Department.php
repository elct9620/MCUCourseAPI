<?php

$app->get('/departments', function () use ($app) {

    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Departments');
    $queryHelper->addFilter('name');
    $queryHelper->usePage(PER_PAGE);

    return $app->response->setJsonContent($queryHelper->result());
});

$app->get('/department/{code:[0-9]+}', function ($code) use ($app) {

    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Departments');
    $queryHelper->addFilter('code', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE, $code);

    return $app->response->setJsonContent($queryHelper->result());

});
