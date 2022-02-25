<?php
/*Create API*/
header('Content-Type: application/json');

include("../db.php");

$recipe_id = $_POST['recipe_id'];
$ingredient = $_POST['ingredient'];

$stmt = $db->prepare("INSERT into ingredients (recipe_id, ingredient) VALUES (?, ?)");
$result = $stmt->execute([$recipe_id, $ingredient]);

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