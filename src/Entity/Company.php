<?php

namespace PhpCycleOrm\Entity;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;

#[Entity]
class Company
{
    #[Column(type:'primary')]
    protected int $id;

    #[Column(type: 'string:255')]
    protected string $company_name;

    #[Column(type: 'string:255')]
    protected string $company_business;
}
