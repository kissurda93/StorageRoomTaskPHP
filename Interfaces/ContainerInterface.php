<?php

namespace Interfaces;

interface ContainerInterface
{
	/**
	 * Total amount of storage-capacity in space-units
	 *
	 * @return int
	 */
	public function getStorageSpace(): int;

	/**
	 * List of ammount of stored ingredients in the container
	 * @return array of items:  key:ingredientName, value stored quantity
	 */
	public function getStoredItems(): array;

	/**
	 * Container id:
	 * should be automatical created, with format:
	 * box1, box2, fridge1,fridge2,fridge3
	 * note: counter should be an incremental value for containertypes independently
	 *
	 * @return string
	 */
	public function getId(): string;

	/**
	 * Used space in container in space-units
	 *
	 * @return int
	 */
	public function getStorageUsed(): int;

	/**
	 * Free space left in container in space-units
	 *
	 * @return int
	 */
	public function getFreeSpace(): int;
}

