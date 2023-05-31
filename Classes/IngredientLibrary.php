<?php 

namespace Classes;

use Classes\Exceptions\IngredientLibraryException;

class IngredientLibrary
{
  private static $ingredients = [
    'meat' => ['spaceUnit' => 12, 'usableContainerTypes' => ['fridge']],
		'salad' => ['spaceUnit' => 30, 'usableContainerTypes' => ['box', 'fridge']],
		'rice' => ['spaceUnit' => 8, 'usableContainerTypes' => ['box']],
		'flour' => ['spaceUnit' => 15, 'usableContainerTypes' => ['box']],
		'fish' => ['spaceUnit' => 15, 'usableContainerTypes' => ['fridge']],
  ];

  public static function getIngredient(string $ingredientName): Ingredient
  {
    if(isset(self::$ingredients[$ingredientName])) {
      return new Ingredient($ingredientName, self::$ingredients[$ingredientName]['spaceUnit'], self::$ingredients[$ingredientName]['usableContainerTypes']);
    } else {
      throw new IngredientLibraryException('Ingredient not found!');
    }
  }
}