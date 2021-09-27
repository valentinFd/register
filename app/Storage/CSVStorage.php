<?php

namespace App\Storage;

use App\Person;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CSVStorage implements Storage
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function add(Person $person): void
    {
        $writer = Writer::createFromPath($this->fileName, "a");
        $writer->setDelimiter(";");
        $writer->insertOne($person->toArray());
    }

    public function searchByPersonId(string $personId): ?Person
    {
        $reader = Reader::createFromPath($this->fileName, "r");
        $reader->setDelimiter(";");
        $stmt = (new Statement())
            ->where(function (array $record) use ($personId)
            {
                return $record[2] === $personId;
            })
            ->limit(1);
        $record = $stmt->process($reader)->fetchOne();
        if (count($record) > 0)
        {
            return new Person(...$record);
        }
        return null;
    }

    public function delete(Person $person): void
    {
        if (($fileRead = fopen($this->fileName, "r")) !== false)
        {
            $persons = [];
            while (($row = fgetcsv($fileRead, 1000, ";")) !== false)
            {
                if ($row[2] !== $person->getPersonId())
                {
                    $persons[] = $row;
                }
            }
            $fileWrite = fopen($this->fileName, "w");
            foreach ($persons as $person)
            {
                fputcsv($fileWrite, $person, ";");
            }
            fclose($fileWrite);
            fclose($fileRead);
        }
    }
}
