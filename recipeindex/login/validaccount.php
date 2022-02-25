<?php
header('Content-Type: application/json');
include ("../db.php");

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $db->prepare('SELECT * from users WHERE username = ? AND password = ?');
$stmt->execute([$username, $password]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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