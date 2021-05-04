<?php

$host = "localhost";
$db_user = "";
$db_password = "";
$db_name =  "";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->set_charset("utf8");
?>
