<?php
$link = mysqli_connect("address_of_db", "username", "password", "username");
        if(mysqli_connect_error()) {
            die("Error connecting to database");
        }
?>
