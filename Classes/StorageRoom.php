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
    $spaceConsuming = $ingredient->getSpaceNeeded($quantity);
    
    foreach ($this->containers as $container) {
      $containerID = $container->getId();
      $freeSpace = $container->getFreeSpace();

      if($freeSpace <= 0) {
        continue;
      }

      if($freeSpace >= $spaceConsuming) {
        $container->storedItems[$ingredientName] = $quantity;
        echo "\t->\t$quantity of $ingredientName added to $containerID\n";
        return;
      } 

      if($freeSpace < $spaceConsuming) {
        $rest = 0;
        while ($freeSpace < $spaceConsuming) {
          $rest++;
          if(($quantity - $rest) <= 0) {
            break;
          }
          $spaceConsuming = $ingredient->getSpaceNeeded($quantity - $rest);
        }

        if($freeSpace >= $spaceConsuming) {
          $storeableQuantity = $quantity - $rest;
          $container->storedItems[$ingredientName] += $storeableQuantity;
          echo "\t->\t$storeableQuantity of $ingredientName added to $containerID\n";
          $quantity = $rest;
          continue;
        } else {
          continue;
        }
      }
    }

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