<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Message;

class CourseTimes extends Model
{
  protected $created_at;
  protected $updated_at;

  public function initialize()
  {
    $this->belongs_to('teacher_id', 'Teachers', 'id');
  }
}
