<?php
header('Content-Type: application/json');
include ("db.php");

$id = (int) $_POST['id'];
// $stmt = $db->prepare("DELETE FROM recipe WHERE recipe_id = ?");
// $stmt = $db->prepare("DELETE FROM ingredients WHERE recipe_id = ?");
$stmt = $db->prepare("DELETE FROM recipe WHERE recipe_id = ?; DELETE FROM ingredients WHERE recipe_id = ?; DELETE from steps WHERE recipe_id = ?; DELETE from ratings where recipe_id = ?");
$result = $stmt->execute([$id, $id, $id, $id]);

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