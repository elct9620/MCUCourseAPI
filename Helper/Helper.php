<?php

namespace MCUCourseAPI\Helper;

class Helper implements \Phalcon\DI\InjectionAwareInterface
{
    protected $di;

    public function setDi($di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }
}
