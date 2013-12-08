<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class Courses extends Model
{
    public $simple_times;
    protected $created_at;
    protected $updated_at;

    public function initialize()
    {
        $this->hasMany('id', 'MCUCourseAPI\Models\Teachers', 'course_id', array(
          'alias' => 'Teachers'
        ));
    }

    public function afterFetch()
    {
        $this->simple_times = $this->getSimpleTimes();
    }

    protected function getSimpleTimes()
    {
        $teachers = $this->getTeachers();

        $simpleTimes = array();
        $times = null;
        $timesItem = null;
        foreach ($teachers as $teacher) {
            $times = $teacher->getCourseTimes();

            $timesItem = array();
            foreach ($times as $time) {
                array_push($timesItem, $time->time);
            }

            array_push($simpleTimes, array(
              'teacher' => $teacher->teacher,
              'camps' => $teacher->camps,
              'day' => $teacher->course_day,
              'times' => $timesItem
            ));
        }
        return $simpleTimes;
    }
}
