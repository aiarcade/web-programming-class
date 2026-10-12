<?php

$host = "mysql";
$user = "student";
$password = "student";
$database = "class_db";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $age = $_POST["age"] !== "" ? (int) $_POST["age"] : null;
    $course = trim($_POST["course"] ?? "");

    // Validate required fields
    if ($name === "" || $email === "") {

        $message = "Name and email are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } else {

        // Insert data
        $sql = "INSERT INTO students (name, email, age, course)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
            "ssis",
            $name,
            $email,
            $age,
            $course
        );

        if ($stmt->execute()) {
            $message = "Student added successfully!";
        } else {

            if ($stmt->errno == 1062) {
                $message = "Email already exists.";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
        }

        .container {
            width: 400px;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 4px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Add Student</h2>

    <?php if ($message !== ""): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <label for="name">Name</label>
        <input
            type="text"
            id="name"
            name="name"
            required
        >

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <label for="age">Age</label>
        <input
            type="number"
            id="age"
            name="age"
            min="1"
            max="150"
        >

        <label for="course">Course</label>
        <input
            type="text"
            id="course"
            name="course"
        >

        <button type="submit">
            Add Student
        </button>

    </form>

</div>

</body>

</html>

<?php
$conn->close();
?>
