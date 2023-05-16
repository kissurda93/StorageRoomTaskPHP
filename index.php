<?php
declare(strict_types=1);

include "autoloader.php";

use Classes\StorageRoomTest;

$application = new StorageRoomTest();

$application->run();