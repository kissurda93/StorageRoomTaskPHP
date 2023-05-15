<?php

namespace Classes;

use Classes\ContainerTypes\Box;
use Classes\ContainerTypes\Refrigerator;
use Classes\Exceptions\StorageRoomException;
use Classes\StorageRoom;

class StorageRoomTest
{
    public function run()
    {
        echo "\nStorageBoxTest\n\n";

        try {
            $storageRoom = new StorageRoom();
            $inventory = new Inventory($storageRoom);
            $storageRoom->addContainer(new Refrigerator());
            $storageRoom->addContainer(new Refrigerator());
            $storageRoom->addContainer(new Box());
            $storageRoom->addContainer(new Box());
            $storageRoom->addContainer(new Box());

            $storageRoom->storeIngredient('meat', 6);
            $storageRoom->storeIngredient('meat', 6);            
            $storageRoom->storeIngredient('salad', 1);
            $storageRoom->storeIngredient('rice', 10);
            $storageRoom->storeIngredient('fish', 1);

            $inventory->listByContainers();

            $storageRoom->getIngredient('salad', 1);

            $storageRoom->getIngredient('meat', 8);
            $storageRoom->getIngredient('rice', 8);

            $inventory->listByContainers();
			$inventory->listByIngredients();



            $storageRoom->getIngredient('rice', 3);
            

        } catch (StorageRoomException $e) {
            echo "\n StorageRoomException:" . $e->getMessage();            
        } catch (\Exception $e) {
            echo "\n Terrible thing happened...:" . $e->getMessage();
        }
    }
}
