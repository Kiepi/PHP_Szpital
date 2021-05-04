<?php

$host = "localhost";
$db_user = "e14_szpital";
$db_password = "e14_mama123@";
$db_name =  "e14_szpital";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
$polaczenie->set_charset("utf8");
?>