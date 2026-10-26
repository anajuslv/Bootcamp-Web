
<?php
require("task04.php");
whoami();

// curl -d "name=Jane&age=21" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://127.0.0.1:8000/index04.php

// Without name 
// curl -d "nom=John&age=48" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://127.0.0.1:8000/index04.php

// Without age 
//curl -d "name=John&age=" -H "Content-Type: application/x-www-form-urlencoded" -X POST http://127.0.0.1:8000/index04.php

// Without name and age 
//curl -X POST http://127.0.0.1:8000/index04.php