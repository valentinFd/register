<?php

require_once("vendor/autoload.php");

use App\Register;
use App\Person;

$register = new Register();
if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["personId"]))
{
    $register->add(new Person($_POST["name"], $_POST["surname"], $_POST["personId"], $_POST["info"]));
    header("Location: index.php");
}
if (isset($_POST["deletePersonId"]))
{
    $register->delete($_POST["deletePersonId"]);
    header("Location: index.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<body>
<table class="table">
    <thead>
    <tr>
        <td>Name</td>
        <td>Surname</td>
        <td>Person id</td>
        <td>Info</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($register->getPersons() as $person)
    {
        if (is_a($person, "App\Person"))
        {
            echo "<tr>";
            foreach ((array)$person as $property)
            {
                echo "<td>$property</td>";
            }
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>
<form method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name"><br>
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname"><br>
        <label for="personId">Person id</label>
        <input type="text" name="personId" id="personId"><br>
        <label for="info">Info</label>
        <textarea class="form-control" name="info" id="info" rows="2"></textarea><br>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</form>
<form method="get">
    <div class="form-group">
        <label for="personId">Person id</label>
        <input type="text" name="personId" id="personId"><br>
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
<?php
if (isset($_GET["personId"]))
{
    $person = $register->searchByPersonId($_GET["personId"]);
    if ($person !== null)
    {
        echo "<table class='table'>";
        echo "<tbody>";
        echo "<tr>";
        foreach ((array)$person as $property)
        {
            echo "<td>$property</td>";
        }
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";
        echo "<form method='post'>";
        echo "<div class='form-group'>";
        echo "<input type='hidden' name='deletePersonId' value={$_GET["personId"]}>";
        echo "<button type='submit' class='btn btn-primary'>Delete</button>";
        echo "</div>";
        echo "</form>";
    }
}
?>
</body>
</html>
