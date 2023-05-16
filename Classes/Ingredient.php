<?php

namespace Classes;

class Ingredient
{
  public function __construct(
    private string $name, 
    private int $spaceUnit,
    private array $usableContainers
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

  public function getUsableContainers(): array
  {
    return $this->usableContainers;
  }
}