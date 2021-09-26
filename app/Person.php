<?php

namespace App;

class Person
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    private string $surname;

    public function getSurname(): string
    {
        return $this->surname;
    }

    private string $personId;

    public function getPersonId(): string
    {
        return $this->personId;
    }

    private string $info;

    public function getInfo(): string
    {
        return $this->info;
    }

    public function __construct(string $name, string $surname, string $personId, string $info = "")
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->personId = $personId;
        $this->info = $info;
    }

    public static function getPropertyNames(): array
    {
        return array_keys(get_class_vars(__CLASS__));
    }
}
