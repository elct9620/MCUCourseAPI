<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class Teachers extends Model
{
    public function initialize()
    {
        $this->belongsTo('course_id', 'Courses', 'id');
        $this->hasMany('id', 'CourseTimes', 'teacher_id');
    }
}
