<?php
require('connect.php');

$id = $_POST['id'];

$result = $conn->query("SELECT * FROM users WHERE id = $id");
$row = $result->fetch_assoc();

echo json_encode($row);
?>