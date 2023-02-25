<?php

declare(strict_types=1);
include 'vendor/autoload.php';

use PhpCycleOrm\Model\User;

$user = new User();

print_r($user->get());