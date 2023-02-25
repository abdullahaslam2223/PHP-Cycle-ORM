<?php

namespace PhpCycleOrm\Model;

use PhpCycleOrm\Lib\ORM\Record;

class User extends Record
{
    public const DATABASE = 'mysql';
    public const TABLE = 'users';

    /**
     * Get fields as array
     *
     * @return array
     */
    public function get(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
