<?php

namespace Classes\ContainerTypes;

class Box extends Container
{
  public function __construct()
  {
    $this->storageSpace = 40;
    $this->id = 'box' . ++parent::$counters['box'];
    parent::__construct();
  }
}