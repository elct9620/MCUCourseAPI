<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class Courses extends Model
{
    protected $created_at;
    protected $updated_at;

    public function initialize()
    {
        $this->hasMany('id', 'Teachers', 'course_id');
    }
}
