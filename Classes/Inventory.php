<?php

namespace Classes;

use Interfaces\StorageRoomInterface;

class Inventory
{
	/**
	 * @var StorageRoomInterface
	 */
	protected StorageRoomInterface $storageRoom;

	/**
	 * @param StorageRoomInterface $storageRoom
	 */
	function __construct(StorageRoomInterface $storageRoom)
	{
		$this->storageRoom = $storageRoom;
	}

	/**
	 * @return void
	 */
	public function listByIngredients()
	{
		$stock = $this->getStock();
		echo "\n\n--------------------------------------------";
		echo "\nStock by ingredients:";
		echo "\n--------------------------------------------";
		foreach ($stock as $ingredientName => $quantity)
		{
			echo "\n" . str_pad($ingredientName, 15) . ": " . str_pad($quantity, 10, " ", STR_PAD_LEFT);
		}
		echo "\n--------------------------------------------\n\n";
	}

	/**
	 * @return void
	 * @throws Exceptions\StorageRoomException
	 */
	public function listByContainers()
	{
		$containers = $this->storageRoom->getContainers();

		echo "\n\nStock by containers:";
		echo "\n--------------------------------------------";

		foreach ($containers as $container)
		{
			$storedItems  = $container->getStoredItems();
			$storageLimit = $container->getStorageSpace();

			$storageUsed = $container->getStorageUsed();

			$ratio = round($storageUsed / $storageLimit * 100, 0);

			echo "\n{$container->getId()}   space: {$storageLimit} , used:{$storageUsed} / {$ratio}%";

			foreach ($storedItems as $ingredientName => $quantity)
			{
				$spaceConsuming = IngredientLibrary::getIngredient($ingredientName)->getSpaceNeeded($quantity);

				echo "\n * " . str_pad($ingredientName, 10) . ":" . str_pad($quantity, 5, " ", STR_PAD_LEFT) . "  (space:{$spaceConsuming})";
			}
			echo "\n\n";
		}
	}

	/**
	 * @return array
	 */
	protected function getStock(): array
	{
		$stock = [];

		$containers = $this->storageRoom->getContainers();

		foreach ($containers as $container)
		{
			$storedItems = $container->getStoredItems();

			foreach ($storedItems as $ingredientName => $quantity)
			{
				$stock[$ingredientName] = ($stock[$ingredientName] ?? 0) + $quantity;
			}
		}

		return $stock;
	}
}
