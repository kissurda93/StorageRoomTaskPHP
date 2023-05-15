<?php
namespace Interfaces;
use Classes\Exceptions\StorageRoomException;

interface StorageRoomInterface
{
	/**
	 * Adds a container instance to storageRoom
	 * @param ContainerInterface $container
	 *
	 * @return void
	 */
    public function addContainer(ContainerInterface $container);

	/**
	 * Stores ingredient identified by ingredientName into containers of storageRoom
	 * @param string $ingredientName
	 * @param int    $quantity
	 *
	 * @return void
	 * @throws StorageRoomException  if storageRoom out of space
	 */
	public function storeIngredient(string $ingredientName, int $quantity);

	/**
	 * Gatheres ammount of ingredient identified by ingredientName from containers of storageRoom
	 * @param string $ingredientName
	 * @param int    $quantity
	 *
	 * @return void
	 * @throws StorageRoomException  if not enough ammount ingredients in storageRoom
	 */
	public function getIngredient(string $ingredientName, int $quantity);

	/**
	 * Container-instances from storageRoom as an array
	 * @return array of ContainerInterface
	 */
	public function getContainers(): array;
}



