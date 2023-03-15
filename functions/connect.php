<?php
function db_con()
{
    require("config.php");
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    return $conn;
}
?>