<?php

namespace Classes\ContainerTypes;

class Box extends Container
{
  private static $count = 0;

  public function __construct()
  {
    $this->id = 'box' . ++self::$count;
    $this->storageSpace = 40;
    parent::__construct();
  }
}