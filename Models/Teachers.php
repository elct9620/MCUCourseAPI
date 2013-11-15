<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Message;

class Teachers extends Model
{
  public function initialize()
  {
    $this->belongsTo('course_id', 'Courses', 'id');
    $this->hasMany('id', 'CourseTimes', 'teacher_id');
  }
}
