<?php
header('Content-Type: application/json');
include ("db.php");


$stmt = $db->prepare("SELECT recipe.user_id, recipe.recipe_id, users.username, recipe.recipe_name, recipe.recipe_description, recipe.servings, recipe.cook_time, recipe.img_name, recipe.category, AVG(NULLIF(ratings.rating,0)) as average
FROM users
JOIN recipe
ON users.id = recipe.user_id
JOIN ratings
WHERE recipe.recipe_id = ratings.recipe_id
GROUP BY recipe.recipe_id
ORDER BY average DESC");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);

?>