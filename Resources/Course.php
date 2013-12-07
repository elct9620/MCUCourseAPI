<?php

use MCUCourseAPI\Helper\QueryHelper;

// All courses
$app->get('/courses', function () use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->usePage(PER_PAGE);
    $queryHelper->addFilter(array('param' => 'name', 'column' => 'course_name'));
    $queryHelper->addFilter('course_code');
    $queryHelper->addFilter('class_code');
    $queryHelper->addFilter(array('param' => 'department', 'column' => 'class_code'), QueryHelper::FILTER_RIGHT);
    $queryHelper->addFilter('year', QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('system', QueryHelper::FILTER_SIMPLE);
    $queryHelper->addFilter('select_type', QueryHelper::FILTER_SIMPLE);

    return $app->response->setJsonContent($queryHelper->result());
});

// Get course by course code and class code
$app->get('/courses/{course_code:[0-9]+}-{class_code:[0-9]+}', function ($courseCode, $classCode) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('course_code', QueryHelper::FILTER_SIMPLE, $courseCode);
    $queryHelper->addFilter('class_code', QueryHelper::FILTER_SIMPLE, $classCode);

    return $app->response->setJsonContent($queryHelper->result());
});

// ID Fallback
$app->get('/courses/{id:[0-9]+}', function ($id) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('id', QueryHelper::FILTER_SIMPLE, $id);

    return $app->response->setJsonContent($queryHelper->result());
});


// Get Data with Course Time
$app->get('/courses/{course_code:[0-9]+}-{class_code:[0-9]+}/times', function ($courseCode, $classCode) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('course_code', QueryHelper::FILTER_SIMPLE, $courseCode);
    $queryHelper->addFilter('class_code', QueryHelper::FILTER_SIMPLE, $classCode);

    $course = $queryHelper->result(false)->getFirst();
    $teachers = $course->getTeachers();

    $courseData = array(
        'course_name' => $course->course_name,
        'course_code' => $course->course_code,
        'class_code' => $course->class_code

    );

    $timesData = array();

    foreach ($teachers as $teacher) {
        $courseTimes = $teacher->getCourseTimes();
        $times = array();
        foreach ($courseTimes as $time) {
            array_push($times, $time->time);
        }
        array_push($timesData, array(
          'teacher' => $teacher->teacher,
          'day' => $teacher->course_day,
          'items' => $times
        ));
    }

    $courseData['times'] = $timesData;

    return $app->response->setJsonContent($courseData);
});

// ID Fallback

$app->get('/courses/{id:[0-9]+}/times', function ($id) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('id', QueryHelper::FILTER_SIMPLE, $id);

    $course = $queryHelper->result(false)->getFirst();
    $teachers = $course->getTeachers();

    $courseData = array(
        'course_name' => $course->course_name,
        'course_code' => $course->course_code,
        'class_code' => $course->class_code
    );

    $timesData = array();

    foreach ($teachers as $teacher) {
        $courseTimes = $teacher->getCourseTimes();
        $times = array();
        foreach ($courseTimes as $time) {
            array_push($times, $time->time);
        }
        array_push($timesData, array(
          'teacher' => $teacher->teacher,
          'day' => $teacher->course_day,
          'items' => $times
        ));
    }

    $courseData['times'] = $timesData;

    return $app->response->setJsonContent($courseData);
});
