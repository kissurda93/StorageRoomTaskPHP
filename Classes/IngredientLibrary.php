<?php 

namespace Classes;

class IngredientLibrary
{
  private static $ingredients = [
    'meat' => ['spaceUnit' => 12, 'usableContainers' => ['fridge']],
		'salad' => ['spaceUnit' => 30, 'usableContainers' => ['box', 'fridge']],
		'rice' => ['spaceUnit' => 8, 'usableContainers' => ['box']],
		'flour' => ['spaceUnit' => 15, 'usableContainers' => ['box']],
		'fish' => ['spaceUnit' => 15, 'usableContainers' => ['fridge']],
  ];

  public static function getIngredient(string $ingredientName): Object
  {
    foreach (self::$ingredients as $ingredient => $properties) {
      if($ingredient === $ingredientName) {
        return new Ingredient($ingredient, $properties['spaceUnit'], $properties['usableContainers']);
      }
    }
  }
}