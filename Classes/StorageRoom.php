<?php

namespace Classes;

use Interfaces\ContainerInterface;
use Interfaces\StorageRoomInterface;
use Classes\Exceptions\StorageRoomException;

class StorageRoom implements StorageRoomInterface
{
  private array $containers = [];

  public function addContainer(ContainerInterface $container): void
  {
    $this->containers[] = $container;
  }

  public function storeIngredient(string $ingredientName, int $quantity): void
  {
    echo "\t->trying to store $quantity $ingredientName\n";
    $ingredient = IngredientLibrary::getIngredient($ingredientName);
    $usableContainerTypes = $ingredient->getUsableContainerTypes();

    foreach ($usableContainerTypes as $usableContainerType) {
      $storedQuantity = $this->checkUsableContainers($ingredient, $quantity, $usableContainerType);

      if($storedQuantity == $quantity) {
        break;
      }

      $quantity -= $storedQuantity;
    }

    if($storedQuantity != $quantity) {
      throw new StorageRoomException("Error: $ingredientName cannot be stored\n");
    }
  }

	public function getIngredient(string $ingredientName, int $quantity): void
  {
    echo "\t->trying to get $quantity of $ingredientName\n";
    $gatheredQuantity = 0;
    $originalQuantity = $quantity;
    $ingredient = IngredientLibrary::getIngredient($ingredientName);

    foreach ($this->containers as $container) {
      $storedItems = $container->getStoredItems();
      
      if(isset($storedItems[$ingredientName])) {
        $returnedQuantity = $container->gatherIngredient($ingredient, $quantity);
        $quantity -= $returnedQuantity;
        $gatheredQuantity += $returnedQuantity;

        if($gatheredQuantity == $originalQuantity) {
          break;
        }
      }
    }

    $missing = $originalQuantity - $gatheredQuantity;
    echo "\t->\tsuccessfully gathered $gatheredQuantity of $ingredientName missing:$missing\n";

    if($missing != 0) {
      throw new StorageRoomException("Error: $ingredientName can not be gathered: needed:$originalQuantity, found:$gatheredQuantity\n");
    }
  }

  public function getContainers(): array
  {
    return $this->containers;
  }

  private function checkUsableContainers(Ingredient $ingredient, int $quantity, string $usableContainerType): int
  {
    $totalStoredQuantity = 0;
    $originalQuantity = $quantity;

    foreach ($this->containers as $container) {
      $containerID = $container->getId();
      $containerType = preg_replace('/\d/u', '', $containerID);

      if($containerType != $usableContainerType) {
        continue;
      }

      $storedQuantity = $container->storeIngredient($ingredient, $quantity);
      $quantity -= $storedQuantity;
      $totalStoredQuantity += $storedQuantity;

      if($totalStoredQuantity == $originalQuantity) {
        return $totalStoredQuantity;
      }
    }

    return $totalStoredQuantity;
  }
}