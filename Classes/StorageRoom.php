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
    $usableContainers = $ingredient->getUsableContainers();

    foreach ($usableContainers as $usableContainer) {
      $success = $this->storageInContainer($ingredient, $quantity, $usableContainer);
      if($success) {
        break;
      }
    }

    if(!$success) {
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
      $containerID = $container->getId();
      $storedItems = $container->getStoredItems();

      foreach ($storedItems as $ingredientInContainer => $quantityInContainer) {
        if($ingredientInContainer == $ingredientName) {

          if($quantityInContainer > $quantity) {
            $newQuantity = $quantityInContainer - $quantity;
            $container->setIngredient($ingredient, $newQuantity);
            $gatheredQuantity += $quantity;
            echo "\t->\t$quantity of $ingredientName got from $containerID\n";
            break 2;
          }

          $gatheredQuantity += $quantityInContainer;
          $quantity -= $quantityInContainer; 
          $container->setIngredient($ingredient, 0);
          echo "\t->\t$quantityInContainer of $ingredientName got from $containerID\n";
        }
      }

      if($gatheredQuantity == $originalQuantity) {
        break;
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

  private function storageInContainer(Ingredient $ingredient, int $quantity, string $usableContainer): bool
  {
    foreach ($this->containers as $container) {
      $containerID = $container->getId();
      $containerType = preg_replace('/\d/u', '', $containerID);

      if($containerType != $usableContainer) {
        continue;
      }

      $freeSpace = $container->getFreeSpace();
      $ingredientName = $ingredient->getName();
      $spaceConsuming = $ingredient->getSpaceNeeded($quantity);
      
      if($freeSpace >= $spaceConsuming) {
        $container->setIngredient($ingredient, $quantity);
        echo "\t->\t$quantity of $ingredientName added to $containerID\n";
        return true;
      }
      
      $result = ($freeSpace / $ingredient->getSpaceUnit());
      $storableQuantity = floor($result);

      if($storableQuantity >= 1) {
        $container->setIngredient($ingredient, $storableQuantity);
        echo "\t->\t$storableQuantity of $ingredientName added to $containerID\n";
        $quantity -= $storableQuantity;
      }
    }
    return false;
  }
}