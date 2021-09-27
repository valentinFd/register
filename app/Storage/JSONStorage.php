<?php

namespace App\Storage;

use App\Person;

class JSONStorage implements Storage
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function add(Person $person): void
    {
        $records = json_decode(file_get_contents($this->fileName), true);
        $records[] = $person->toArray();
        file_put_contents($this->fileName, json_encode($records));
    }

    public function searchByPersonId(string $personId): ?Person
    {
        $records = json_decode(file_get_contents($this->fileName), true);
        $persons = [];
        foreach ($records as $record)
        {
            $persons[] = new Person(...array_values($record));
        }
        /** @var Person $person */
        foreach ($persons as $person)
        {
            if ($person->getPersonId() === $personId)
            {
                return $person;
            }
        }
        return null;
    }

    public function delete(Person $person): void
    {
        $records = json_decode(file_get_contents($this->fileName), true);
        $persons = [];
        foreach ($records as $record)
        {
            if ($record["personId"] !== $person->getPersonId())
            {
                $persons[] = $record;
            }
        }
        file_put_contents($this->fileName, json_encode($persons));
    }
}
