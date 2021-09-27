<?php

namespace App;

class Person
{
    private string $name;

    private string $surname;

    private string $personId;

    public function getPersonId(): string
    {
        return $this->personId;
    }

    private string $info;

    public function __construct(string $name, string $surname, string $personId, string $info = "")
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->personId = $personId;
        $this->info = $info;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
