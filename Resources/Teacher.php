<?php

$app->get('/teachers', function () use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Teachers');
    $queryHelper->addFilter(array('param' => 'name', 'column' => 'teacher'));
    $queryHelper->usePage(PER_PAGE);

    return $app->response->setJsonContent($queryHelper->result());
});

$app->get('/teachers/{name}', function ($name) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Teachers');
    $queryHelper->addFilter(
        array('param' => 'name', 'column' => 'teacher'),
        MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE,
        $name
    );

    return $app->response->setJsonContent($queryHelper->result());
});
