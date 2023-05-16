<?php

namespace Classes;

class ContainerWatcher
{
  public function checkIngredient(Ingredient $ingredient, string $containerID): bool
  {
    $containerType = preg_replace('/\d/u', '', $containerID);
    $usableContainers = $ingredient->getUsableContainers();
    
    return in_array($containerType, $usableContainers) ? true : false;
  }
}