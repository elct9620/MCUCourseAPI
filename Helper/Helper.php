<?php

class Helper implements \Phalcon\DI\InjectionAwareInterface
{
  protected $_di;

  public function setDi($di)
  {
    $this->_di = $di;
  }

  public function getDi()
  {
    return $this->_di;
  }
}
