<?php
header('Content-Type: application/json');

include("../db.php");

$username = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];

$stmt = $db->prepare("INSERT INTO users (username, first_name, last_name, password) VALUES(?,?,?,?)");
$result = $stmt->execute([$username, $first_name, $last_name, $password]);

if($result){
    echo json_encode([
    'code' => 'success'
    ]);
}else{
    echo json_encode([
        'code' => 'fail'
        ]);
}
?>