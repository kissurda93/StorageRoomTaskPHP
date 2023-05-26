<?php

namespace Classes;

class Ingredient
{
  public function __construct(
    private string $name, 
    private int $spaceUnit,
    private array $usableContainerTypes,
  )
  {}

  public function getSpaceUnit(): int
  {
    return $this->spaceUnit;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getUsableContainerTypes(): array
  {
    return $this->usableContainerTypes;
  }

  public function getSpaceNeeded(int $quantity): int
  {
    return ($this->spaceUnit * $quantity);
  }
}