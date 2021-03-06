<?php

namespace MCUCourseAPI\Models;

use Phalcon\Mvc\Model;

class CourseTimes extends Model
{
    protected $created_at;
    protected $updated_at;

    public function initialize()
    {
        $this->belongsTo('teacher_id', 'MCUCourseAPI\Models\Teachers', 'id', array(
          'alias' => 'Teachers'
        ));
    }
}
