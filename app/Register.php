<?php

namespace App;

use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class Register
{
    private array $persons;

    public function getPersons(): array
    {
        return $this->persons;
    }

    public function __construct()
    {
        $this->persons = [];
        $csv = Reader::createFromPath("persons.csv", "r");
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(";");
        $persons = Statement::create()->process($csv);
        foreach ($persons as $person)
        {
            $this->persons[] = new Person(...array_values($person));
        }
    }

    public function add(Person $person): void
    {
        $this->persons[] = $person;
        $this->save();
    }

    public function delete(string $personId): void
    {
        $id = $this->find($personId);
        if ($id !== -1)
        {
            array_splice($this->persons, $id, 1);
            $this->save();
        }
    }

    public function searchByPersonId(string $personId): ?Person
    {
        /** @var Person $person */
        foreach ($this->persons as $person)
        {
            if ($person->getPersonId() === $personId)
            {
                return $person;
            }
        }
        return null;
    }

    private function save(): void
    {
        $writer = Writer::createFromPath("persons.csv", "w");
        $writer->setDelimiter(";");
        $writer->insertOne(Person::getPropertyNames());
        foreach ($this->persons as $person)
        {
            $writer->insertOne((array)$person);
        }
    }

    private function find(string $personId): int
    {
        /** @var Person $person */
        foreach ($this->persons as $id => $person)
        {
            if ($person->getPersonId() === $personId)
            {
                return $id;
            }
        }
        return -1;
    }
}
