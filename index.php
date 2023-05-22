<?php
declare(strict_types=1);

include "autoLoader.php";

use Classes\StorageRoomTest;

$application = new StorageRoomTest();

$application->run();