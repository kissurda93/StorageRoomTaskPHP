<?php 

namespace Classes;

class IngredientLibrary
{
  private static $ingredients = [
    'meat' => 12,
		'salad' => 30,
		'rice' => 8,
		'flour' => 15,
		'fish' => 15,
  ];

  public static function getIngredient(string $ingredientName): Object
  {
    foreach (self::$ingredients as $ingredient => $spaceUnit) {
      if($ingredient === $ingredientName) {
        return new Ingredient($ingredient, $spaceUnit);
      }
    }
  }
}