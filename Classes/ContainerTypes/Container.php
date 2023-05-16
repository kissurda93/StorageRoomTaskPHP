<?php

namespace Classes\ContainerTypes;

use Classes\IngredientLibrary;
use Interfaces\ContainerInterface;

abstract class Container implements ContainerInterface
{
  public array $storedItems = [];
  protected int $storageSpace;
  protected string $id;

  public function __construct()
  {
    echo "new container created:$this->id\n";
  }

  public function getStorageSpace(): int
  {
    return $this->storageSpace;
  }

	public function getStoredItems(): array
  {
    return $this->storedItems;
  }

	public function getId(): string
  {
    return $this->id;
  }

	public function getStorageUsed(): int
  {
    $usedSpace = 0;
    foreach ($this->storedItems as $ingredient => $quantity) {
      $spaceConsuming = IngredientLibrary::getIngredient($ingredient)->getSpaceNeeded($quantity);
      $usedSpace += $spaceConsuming;
    }
    return $usedSpace;
  }

	public function getFreeSpace(): int
  {
    $usedSpace = 0;
    foreach ($this->storedItems as $ingredient => $quantity) {
      $spaceConsuming = IngredientLibrary::getIngredient($ingredient)->getSpaceNeeded($quantity);
      $usedSpace += $spaceConsuming;
    }
    return ($this->storageSpace - $usedSpace);
  }
}
