<?php

require_once("vendor/autoload.php");

use App\Person;
use App\Storage\CSVStorage;
use App\Storage\JSONStorage;

if (isset($_POST["add"]) && isset($_POST["storage"]))
{
    if ($_POST["name"] !== "" && $_POST["surname"] !== "" && $_POST["personId"] !== "")
    {
        switch ($_POST["storage"])
        {
            case "csv":
                $storage = new CSVStorage("storage/persons.csv");
                break;
            case "json":
                $storage = new JSONStorage("storage/persons.json");
                break;
        }
        $storage->add(new Person($_POST["name"], $_POST["surname"], $_POST["personId"], $_POST["info"]));
        header("Location: /");
    }
}
if (isset($_POST["deletePersonId"]) && isset($_POST["storage"]))
{
    switch ($_POST["storage"])
    {
        case "csv":
            $storage = new CSVStorage("storage/persons.csv");
            break;
        case "json":
            $storage = new JSONStorage("storage/persons.json");
            break;
    }
    $storage->delete($storage->searchByPersonId($_POST["deletePersonId"]));
    header("Location: /");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous">
    <title>Register</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <form method="post">
                <div class="mb-3">
                    <label for="storage" class="form-label">Storage</label>
                    <select name="storage" id="storage" class="form-select w-25">
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control w-50" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" class="form-control w-50" id="surname" name="surname">
                </div>
                <div class="mb-3">
                    <label for="personId" class="form-label">Person id</label>
                    <input type="text" class="form-control w-50" id="personId" name="personId">
                </div>
                <div class="mb-3">
                    <label for="info" class="form-label">Info</label>
                    <textarea class="form-control w-50" id="info" name="info" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="add">Add</button>
            </form>
        </div>
        <div class="col">
            <form method="get">
                <div class="mb-3">
                    <label for="storage" class="form-label">Storage</label>
                    <select name="storage" id="storage" class="form-select w-25">
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="search" class="form-label">Person id</label>
                    <input type="text" class="form-control w-50" id="search" name="search">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <?php
            if (isset($_GET["search"]) && isset($_GET["storage"])):
                switch ($_GET["storage"])
                {
                    case "csv":
                        $storage = new CSVStorage("storage/persons.csv");
                        break;
                    case "json":
                        $storage = new JSONStorage("storage/persons.json");
                        break;
                }
                if ($storage->searchByPersonId($_GET["search"]) !== null):?>
                    <div class="row">
                        <?php
                        foreach ($storage->searchByPersonId($_GET["search"])->toArray() as $property)
                        {
                            echo "<div class='col mb-3'>$property</div>";
                        }
                        ?>
                        <form method="post">
                            <div class="mb-3">
                                <input type="hidden" name="storage" value=<?php
                                echo "{$_GET["storage"]}" ?>>
                                <button type="submit" class="btn btn-primary" name="deletePersonId"
                                        value=<?php
                                echo "{$_GET["search"]}"; ?>>Delete
                                </button>
                            </div>
                        </form>
                    </div>
                <?php
                endif;
            endif; ?>
        </div>
    </div>
</div>
</body>
</html>
