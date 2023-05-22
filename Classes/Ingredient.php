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

  public function getSpaceUnit(): int
  {
    return $this->spaceUnit;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getUsableContainers(): array
  {
    return $this->usableContainers;
  }

  public function getSpaceNeeded(int $quantity): int
  {
    return ($this->spaceUnit * $quantity);
  }

  public function checkContainer(string $containerID): bool
  {
    $containerType = preg_replace('/\d/u', '', $containerID);
    return in_array($containerType, $this->usableContainers) ? true : false;
  }
}