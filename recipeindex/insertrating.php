<?php
header('Content-Type: application/json');

include("db.php");

$userId = (int) $_POST['user_id'];
$recipeId = (int) $_POST['recipe_id'];
$recipeRating = (int) $_POST['rating'];
$recipeComment = $_POST['comment'];

$stmt = $db->prepare("INSERT into ratings (user_id, recipe_id, rating, comments) VALUES (?, ?, ?, ?)");
$result = $stmt->execute([$userId, $recipeId, $recipeRating, $recipeComment]);

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