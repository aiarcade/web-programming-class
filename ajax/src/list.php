<?php

$host = "mysql";
$user = "student";
$password = "student";
$database = "class_db";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get students
$sql = "SELECT id, name, email, age, course, created_at
        FROM students
        ORDER BY id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}

?>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Age</th>
        <th>Course</th>
        <th>Created At</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= htmlspecialchars($row["age"] ?? "") ?></td>
            <td><?= htmlspecialchars($row["course"]) ?></td>
            <td><?= htmlspecialchars($row["created_at"]) ?></td>
        </tr>

    <?php endwhile; ?>

</table>

<?php
$conn->close();
?>
