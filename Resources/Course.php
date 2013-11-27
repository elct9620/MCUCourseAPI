<?php

// All courses
$app->get('/courses', function () use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->usePage(PER_PAGE);
    $queryHelper->addFilter(array('param' => 'name', 'column' => 'course_name'));
    $queryHelper->addFilter('course_code');
    $queryHelper->addFilter('class_code');

    return $app->response->setJsonContent($queryHelper->result());
});

// Get course by id
$app->get('/course/{class_code:[0-9]+}', function ($classCode) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('class_code', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE, $classCode);

    return $app->response->setJsonContent($queryHelper->result());
});

// Get Data with Course Time
$app->get('/course/{class_code:[0-9]+}/times', function ($classCode) use ($app) {
    $queryHelper = $app->queryHelper;
    $queryHelper->setModel('MCUCourseAPI\Models\Courses');
    $queryHelper->addFilter('class_code', MCUCourseAPI\Helper\QueryHelper::FILTER_SIMPLE, $classCode);

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
          'day' => $teacher->course_day,
          'times' => $times
        ));
    }

    $courseData['times'] = $timesData;

    return $app->response->setJsonContent($courseData);
});
