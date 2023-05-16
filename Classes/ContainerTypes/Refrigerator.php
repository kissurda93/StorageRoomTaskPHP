<?php

namespace Classes\ContainerTypes;

class Refrigerator extends Container
{
  private static int $count = 0;

  public function __construct()
  {
    $this->id = 'fridge' . ++self::$count;
    $this->storageSpace = 100;
    parent::__construct();
  }
}