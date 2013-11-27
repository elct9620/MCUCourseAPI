<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class Courses extends Model
{
    public $teachers;

    protected $created_at;
    protected $updated_at;

    public function initialize()
    {
        $this->hasMany('id', 'MCUCourseAPI\Models\Teachers', 'course_id', array(
          'alias' => 'Teachers'
        ));
    }
}
