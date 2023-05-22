<?php

namespace Classes\ContainerTypes;

use Classes\Ingredient;
use Classes\IngredientLibrary;
use Interfaces\ContainerInterface;

abstract class Container implements ContainerInterface
{
  protected array $storedItems = [];
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

  public function setIngredient(Ingredient $ingredient, int $quantity): void
  {
    $ingredientName = $ingredient->getName();

    if($quantity === 0) {
      unset($this->storedItems[$ingredientName]);
      return;
    }

    $this->storedItems[$ingredientName] = isset($this->storedItems[$ingredientName]) 
      ? $this->storedItems[$ingredientName] + $quantity
      : $quantity;
  }
}
