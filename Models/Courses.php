<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Message;

class Courses extends Model
{
  protected $created_at;
  protected $updated_at;

  public function initialize()
  {
    $this->hasMany('id', 'Teachers', 'course_id');
  }
}
