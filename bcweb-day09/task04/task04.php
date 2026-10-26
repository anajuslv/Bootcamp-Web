
<?php

function whoami(): void
{
    $name = $_POST["name"] ?? "";
    $age = $_POST["age"] ?? "";

    $valid_age = $age !== "" && filter_var($age, FILTER_VALIDATE_INT) !== false && (int)$age >= 0;

    if ($name !== "" && $valid_age) {
        echo "Hi, my name is $name and I'm $age years old.";
    } elseif ($name === "" && $valid_age) {
        echo "Hi, I have no name and I'm $age years old.";
    } elseif ($name !== "") {
        echo "Hi, my name is $name.";
    } else {
        echo "Hi, I`m no one";
    }
}
