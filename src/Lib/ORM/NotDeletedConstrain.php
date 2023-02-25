<?php

namespace src\Lib\ORM;

use Cycle\ORM\Select\ScopeInterface;
use Cycle\ORM\Select\QueryBuilder;

class NotDeletedConstrain implements ScopeInterface
{
    public function apply(QueryBuilder $query): void
    {
        $query->where('deleted_at', '=', null);
    }
}
