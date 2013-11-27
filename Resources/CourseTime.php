<?php

$app->get('/course_times/{time:[0-9]+}/courses', function ($time) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\CourseTimes');
    $queryHelper->usePage(PER_PAGE);
    $queryHelper->addFilter('course_day', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('time', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE, $time);

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
          'Teachers.teacher',
          'Teachers.course_day',
          'time'
        ),
        null
    );

    return $app->response->setJsonContent($queryHelper->result());
});
