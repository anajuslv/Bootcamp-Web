
<?php
function get_shortest(array $strings): string
{
    $shortest = $strings[0];

    foreach ($strings as $string) {
        if (strlen($string) < strlen($shortest)) {
            $shortest = $string;
        }
    }

    return $shortest;
}
