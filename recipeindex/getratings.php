<?php
header('Content-Type: application/json');
include ("db.php");

// $recipeId = (int) $_POST['recipeId'];
$stmt = $db->prepare("SELECT users.firstname, ratings.user_id, ratings.recipe_id, ratings.rating, ratings.comments FROM users INNER JOIN ratings ON users.id = ratings.user_id");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);

?>