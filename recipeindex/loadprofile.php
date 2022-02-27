<?php
header('Content-Type: application/json');
include ("db.php");

$id = (int) $_POST['id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);

?>