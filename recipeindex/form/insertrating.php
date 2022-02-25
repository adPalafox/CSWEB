<?php
/*Create API*/
header('Content-Type: application/json');

include("../db.php");

$user_id = $_POST['userId'];
$recipe_id = $_POST['recipeId'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

$stmt = $db->prepare("INSERT into ratings (user_id, recipe_id, rating, comments) VALUES (?, ?, ?, ?)");
$result = $stmt->execute([$user_id, $recipe_id, $rating, $comment]);

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