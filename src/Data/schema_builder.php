<?php

require __DIR__ . "/../../vendor/autoload.php";

use PhpCycleOrm\Lib\SchemaBuilder;

$schema = (new SchemaBuilder())->SyncSchema();

print_r($schema);