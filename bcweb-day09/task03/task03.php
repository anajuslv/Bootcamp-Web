
<?php

function dynamic_body(): string
{
    $page = $_GET["page"] ?? "";

    if ($page === "home" || $page === "php" || $page === "sql") {
        $content = file_get_contents($page . ".html");

        if ($content !== false) {
            return $content;
        }
    }

    return "<p>Unknown page</p>";
}
