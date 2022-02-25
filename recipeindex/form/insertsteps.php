<?php
/*Create API*/
header('Content-Type: application/json');

include("../db.php");

$recipe_id = $_POST['recipe_id'];
$steps = $_POST['steps'];

$stmt = $db->prepare("INSERT into steps (recipe_id, steps) VALUES (?, ?)");
$result = $stmt->execute([$recipe_id, $steps]);

if($result){
    echo json_encode([
    'code' => '201'
    ]);
}else{
    echo json_encode([
        'code' => '400'
        ]);
}


?>