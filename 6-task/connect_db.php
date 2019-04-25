<?php
    define("HOST", "localhost");
    define("USER", "root");
    define("PASS", "8666");
    define("DB", "local_users");

    $connection = mysqli_connect('localhost', 'root', '8666');
    $select_db = mysqli_select_db($connection, 'local_users');
?>