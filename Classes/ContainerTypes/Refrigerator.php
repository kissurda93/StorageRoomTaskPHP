<?php

namespace Classes\ContainerTypes;

class Refrigerator extends Container
{
  public function __construct()
  {
    $this->storageSpace = 100;
    $this->id = 'fridge' . ++parent::$counters['fridge'];
    parent::__construct();
  }
}