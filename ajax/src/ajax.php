<?php

$host = "mysql";
$user = "student";
$password = "student";
$database = "class_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);

    echo json_encode([
        "error" => "Database connection failed"
    ]);

    exit;
}

header("Content-Type: application/json");

$sql = "SELECT id, name, email, age, course, created_at
        FROM students
        ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);

    echo json_encode([
        "error" => "Database query failed"
    ]);

    exit;
}

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);

$conn->close();
?>
