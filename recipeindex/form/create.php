<?php
/*Create API*/
header('Content-Type: application/json');

include("../db.php");

$recipe_name = $_POST['recipeName'];
$recipe_description = $_POST['recipeDescription'];
$recipe_cooktime = $_POST['recipeCooktime'];
$recipe_servings = $_POST['recipeServings'];
$recipe_category = $_POST['recipeCategory'];

$stmt = $db->prepare("INSERT INTO students (name, age, address, section) VALUES (?, ?, ?, ?)");
$result = $stmt->execute([$name, $age, $address, $section]);

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