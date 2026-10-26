
<?php

function render_body(string $page): string
{
    if ($page === "home" || $page === "php" || $page === "sql") {
        return file_get_contents($page . ".html");
    }

    return "<p>Unknown page</p>";
}
