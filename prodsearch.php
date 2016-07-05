<?php
require_once 'db_conn.php';
$searchTerm = $_GET['term'];

$query = $conn->query("SELECT productName from products WHERE productName LIKE '%".$searchTerm."%' order by productName ASC");
while ($row = $query->fetch_assoc()) {
	$data[] = $row['productName'];
}

echo json_encode($data);
?>