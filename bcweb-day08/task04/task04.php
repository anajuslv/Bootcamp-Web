
<?php
function calc(string $operator, int $nbr1, int $nbr2)
{
    if ($operator === "+") {
        return $nbr1 + $nbr2;
    } elseif ($operator === "-") {
        return $nbr1 - $nbr2;
    } elseif ($operator === "*") {
        return $nbr1 * $nbr2;
    } elseif ($operator === "/") {
        if ($nbr2 === 0) {
            return "Cannot divide by 0";
        }
        return $nbr1 / $nbr2;
    } elseif ($operator === "%") {
        if ($nbr2 === 0) {
            return "Cannot divide by 0";
        }
        return $nbr1 % $nbr2;
    } else {
        return "Unknown operator";
    }
}
