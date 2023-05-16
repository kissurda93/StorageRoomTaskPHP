<?php

namespace Classes;

use Interfaces\ContainerInterface;
use Interfaces\StorageRoomInterface;
use Classes\Exceptions\StorageRoomException;

class StorageRoom implements StorageRoomInterface
{
  private $containers = [];

  public function addContainer(ContainerInterface $container): void
  {
    $this->containers[] = $container;
  }

  public function storeIngredient(string $ingredientName, int $quantity): void
  {
    echo "\t->trying to store $quantity $ingredientName\n";

    $ingredient = IngredientLibrary::getIngredient($ingredientName);
    
    foreach ($this->containers as $container) {
      $containerID = $container->getId();

      if(!$ingredient->checkContainer($containerID)) {
        continue;
      }

      $freeSpace = $container->getFreeSpace();
      $spaceConsuming = $ingredient->getSpaceNeeded($quantity);
      
      if($freeSpace >= $spaceConsuming) {
        $container->storedItems[$ingredientName] = isset($container->storedItems[$ingredientName]) 
        ? $container->storedItems[$ingredientName] + $quantity
        : $quantity;

        echo "\t->\t$quantity of $ingredientName added to $containerID\n";
        return;
      } 
      
      $result = ($freeSpace / $ingredient->getSpaceUnit());
      $storeableQuantity = floor($result);

      if($storeableQuantity >= 1) {
        $container->storedItems[$ingredientName] = isset($container->storedItems[$ingredientName]) 
        ? $container->storedItems[$ingredientName] + $storeableQuantity
        : $storeableQuantity;
        
        echo "\t->\t$storeableQuantity of $ingredientName added to $containerID\n";
        $quantity -= $storeableQuantity;
      }
    }

    throw new StorageRoomException("Error: $ingredientName cannot be stored");
  }

	public function getIngredient(string $ingredientName, int $quantity): void
  {
    echo "\t->trying to get $quantity of $ingredientName\n";
    $gatheredQuantity = 0;
    $originalQuantity = $quantity;

    foreach ($this->containers as $container) {
      $containerID = $container->getId();

      foreach ($container->storedItems as $ingredient => $quantityInContainer) {
        if($ingredient == $ingredientName) {

          if($quantityInContainer > $quantity) {
            $container->storedItems[$ingredient] -= $quantity;
            $gatheredQuantity += $quantity;
            echo "\t->\t$quantity of $ingredientName got from $containerID\n";
            break;
          }

          $gatheredQuantity += $quantityInContainer;
          $quantity -= $quantityInContainer; 
          unset($container->storedItems[$ingredient]);
          echo "\t->\t$quantityInContainer of $ingredientName got from $containerID\n";
        }
      }
    }

    $missing = $originalQuantity - $gatheredQuantity;
    echo "\t->\tsuccessfully gathered $gatheredQuantity of $ingredientName missing:$missing\n";

    if($missing != 0) {
      throw new StorageRoomException("Error: $ingredientName can not be gathered: needed:$originalQuantity, found:$gatheredQuantity");
    }

  }

  public function getContainers(): array
  {
    return $this->containers;
  }
}