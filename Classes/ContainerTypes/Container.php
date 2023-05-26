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
  protected static array $counters = [
    'box' => 0,
    'fridge' => 0,
  ];

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
    $usedSpace = $this->getStorageUsed();
    return ($this->storageSpace - $usedSpace);
  }

  public function gatherIngredient(Ingredient $ingredient, int $quantity): int
  {
    $containerID = $this->id;
    $ingredientName = $ingredient->getName();
    $quantityInContainer = $this->storedItems[$ingredientName];

    if($this->storedItems[$ingredientName] > $quantity) {
      $this->decrementQuantity($ingredient, $quantity);
      echo "\t->\t$quantity of $ingredientName got from $containerID\n";
      return $quantity;
    }

    $this->decrementQuantity($ingredient, $quantity);
    echo "\t->\t$quantityInContainer of $ingredientName got from $containerID\n";
    return $quantityInContainer;
  }

  public function storeIngredient(Ingredient $ingredient, int $quantity): int
  {
    $freeSpace = $this->getFreeSpace();
    $ingredientName = $ingredient->getName();
    $spaceConsuming = $ingredient->getSpaceNeeded($quantity);
    
    if($freeSpace >= $spaceConsuming) {
      $this->incrementQuantity($ingredient, $quantity);
      echo "\t->\t$quantity of $ingredientName added to $this->id\n";
      return $quantity;
    }
    
    $storableQuantity = floor($freeSpace / $ingredient->getSpaceUnit());

    if($storableQuantity >= 1) {
      $this->incrementQuantity($ingredient, $storableQuantity);
      echo "\t->\t$storableQuantity of $ingredientName added to $this->id\n";
    }
    
    return $storableQuantity;
  }

  private function incrementQuantity(Ingredient $ingredient, int $quantity): void
  {
    $ingredientName = $ingredient->getName();
    $this->storedItems[$ingredientName] = ($this->storedItems[$ingredientName] ?? 0) + $quantity;
  }

  private function decrementQuantity(Ingredient $ingredient, int $quantity): void
  {
    $ingredientName = $ingredient->getName();
    $this->storedItems[$ingredientName] = $this->storedItems[$ingredientName] - $quantity;

    if($this->storedItems[$ingredientName] <= 0) {
      unset($this->storedItems[$ingredientName]);
    }
  }
}
