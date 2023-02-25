<?php

namespace PhpCycleOrm\Test;

use PhpCycleOrm\Database\Database;

class Test
{
    public function __construct()
    {
        echo "I am from Test.php </br>";
        $Database = new Database();
    }
}
