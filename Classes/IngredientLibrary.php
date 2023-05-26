<?php 

namespace Classes;

class IngredientLibrary
{
  private static $ingredients = [
    'meat' => ['spaceUnit' => 12, 'usableContainerTypes' => ['fridge']],
		'salad' => ['spaceUnit' => 30, 'usableContainerTypes' => ['box', 'fridge']],
		'rice' => ['spaceUnit' => 8, 'usableContainerTypes' => ['box']],
		'flour' => ['spaceUnit' => 15, 'usableContainerTypes' => ['box']],
		'fish' => ['spaceUnit' => 15, 'usableContainerTypes' => ['fridge']],
  ];

  public static function getIngredient(string $ingredientName): Object
  {
    foreach (self::$ingredients as $ingredient => $properties) {
      if($ingredient === $ingredientName) {
        return new Ingredient($ingredient, $properties['spaceUnit'], $properties['usableContainerTypes']);
      }
    }
  }
}