<?php

namespace App\Storage;

use App\Person;

interface Storage
{
    public function add(Person $person): void;

    public function searchByPersonId(string $personId): ?Person;

    public function delete(Person $person): void;
}
