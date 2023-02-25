<?php

namespace PhpCycleOrm\Entity;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;

#[Entity]
class User
{
    #[Column(type: "primary")]
    private int $id;

    #[Column(type: "string")]
    private string $username;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->username;
    }

    public function setName(string $username): void
    {
        $this->username = $username;
    }
}
