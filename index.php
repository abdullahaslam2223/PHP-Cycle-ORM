<?php

declare(strict_types=1);
include 'vendor/autoload.php';

use PhpCycleOrm\Model\User;

$user = User::find()->findOne(['username' => 'abdullah256', 'password' =>  'test123']);

print_r($user->get());