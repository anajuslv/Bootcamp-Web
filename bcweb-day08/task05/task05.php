
<?php
function calc_average(array $numbers): float
{
    $average = array_sum($numbers) / count($numbers);

    return round($average, 1);
}
