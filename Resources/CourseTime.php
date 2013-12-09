<?php

$app->get('/course_times/{time:[0-9]+}/courses', function ($time) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\CourseTimes');
    $queryHelper->usePage(PER_PAGE);
    $queryHelper->addFilter('course_day', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter(array('param' => 'name', 'column' => 'course_name'));
    $queryHelper->addFilter('course_code');
    $queryHelper->addFilter('class_code');
    $queryHelper->addFilter('year', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('select_type', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('system', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('time', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE, $time);

    $isGroup = $app->request->getQuery('group');
    $groupString = null;
    if ($isGroup) {
        $groupString = "Courses.course_code, Courses.class_code";
    }

    # TDOD: improve to more clearly
    $queryHelper->joinTables(
        array(
          array('table' => 'teachers', 'joinOn' => 'teacher_id = Teachers.id'),
          array('table' => 'courses', 'joinOn' => 'Courses.id = Teachers.course_id'),
        ),
        array('teachers', 'courses'),
        array(
          'Courses.id',
          'Courses.course_name',
          'Courses.course_code',
          'Courses.class_code',
          'Courses.year',
          'Courses.credit',
          'Courses.semester',
          'Courses.select_type',
          'Courses.system',
          'Teachers.camps',
          'Teachers.teacher',
          'Teachers.course_day',
          'time'
        ),
        $groupString
    );

    return $app->response->setJsonContent($queryHelper->result());
});
