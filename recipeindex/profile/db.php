<?php

$db_name = "accounts";
$db_server = "";
$db_user = "root";
$db_pass = "";

$db = new PDO("mysql:host={$db_server};dbname={$db_name};charset=utf8", $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>  