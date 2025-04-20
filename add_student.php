<?php
include('db.php');

$name = trim($_POST['name']);
$roll = trim($_POST['roll_number']);

if (!empty($name) && !empty($roll)) {
    $stmt = $conn->prepare("INSERT INTO students (name, roll_number) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $roll);

    if ($stmt->execute()) {
        echo "Student added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Please fill all fields.";
}

$conn->close();
?>