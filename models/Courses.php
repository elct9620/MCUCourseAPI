<?php

use Phalcon\Mvc\Model,
    Phalcon\Mvc\Message;

class Courses extends Model
{
  public function getSource()
  {
    return "courses";
  }
}
