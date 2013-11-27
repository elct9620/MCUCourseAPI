<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class Teachers extends Model
{
    protected $created_at;
    protected $updated_at;

    public function initialize()
    {
        $this->belongsTo('course_id', 'MCUCourseAPI\Models\Courses', 'id', array(
          'alias' => 'Courses'
        ));
        $this->hasMany('id', 'MCUCourseAPI\Models\CourseTimes', 'teacher_id', array(
          'alias' => 'CourseTimes'
        ));
    }
}
