<?php

namespace Classes;

class Ingredient
{
  public function __construct(
    private $name, 
    private $spaceUnit
  )
  {}

  public function getSpaceNeeded(int $quantity): int
  {
    return ($this->spaceUnit * $quantity);
  }

  public function getSpaceUnit(): int
  {
    return $this->spaceUnit;
  }
}