<?php

namespace Classes;

use Interfaces\ContainerInterface;
use Interfaces\StorageRoomInterface;
use Classes\Exceptions\StorageRoomException;

class StorageRoom implements StorageRoomInterface
{
  private $containers = [];

  public function addContainer(ContainerInterface $container)
  {
    $this->containers[] = $container;
  }

  public function storeIngredient(string $ingredientName, int $quantity)
  {
    echo "\t->trying to store $quantity $ingredientName\n";

    $ingredient = IngredientLibrary::getIngredient($ingredientName);
    
    foreach ($this->containers as $container) {
      $spaceConsuming = $ingredient->getSpaceNeeded($quantity);
      $containerID = $container->getId();
      $freeSpace = $container->getFreeSpace();
      
      if($freeSpace >= $spaceConsuming) {
        $container->storedItems[$ingredientName] = isset($container->storedItems[$ingredientName]) 
        ? $container->storedItems[$ingredientName] + $quantity
        : $quantity;

        echo "\t->\t$quantity of $ingredientName added to $containerID\n";
        return;
      } 
      
      if($freeSpace < $spaceConsuming) {
        $result = ($freeSpace / $ingredient->getSpaceUnit());
        $storeableQuantity = floor($result);

        if($storeableQuantity >= 1) {
          $container->storedItems[$ingredientName] = isset($container->storedItems[$ingredientName]) 
          ? $container->storedItems[$ingredientName] + $storeableQuantity
          : $storeableQuantity;
          
          echo "\t->\t$storeableQuantity of $ingredientName added to $containerID\n";
          $quantity = floor($quantity - $storeableQuantity);
          continue;
        } else {
          continue;
        }
      }
    }

    var_dump($this->getContainers());
    throw new StorageRoomException("$ingredientName cannot store");
  }

	public function getIngredient(string $ingredientName, int $quantity)
  {

  }

  public function getContainers(): array
  {
    return $this->containers;
  }
}