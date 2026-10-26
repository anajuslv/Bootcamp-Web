
<?php
function sequence(int $n): void
{
    if ($n < 0) {
        return;
    }

    $current = "1";

    for ($i = 0; $i <= $n; $i++) {
        echo $current . PHP_EOL;

        $next = "";
        $length = strlen($current);
        $j = 0;

        while ($j < $length) {
            $count = 1;

            while ($j + 1 < $length && $current[$j] === $current[$j + 1]) {
                $count++;
                $j++;
            }

            $next .= $count . $current[$j];
            $j++;
        }

        $current = $next;
    }
}
