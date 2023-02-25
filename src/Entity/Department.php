<?php

namespace PhpCycleOrm\Entity;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;

#[Entity]
class Department
{
    #[Column(type: 'primary')]
    protected int $id;

    #[Column(type: 'string:255')]
    private $name;
}