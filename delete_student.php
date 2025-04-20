<?php
include('db.php');

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Student deleted.";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
header("Location: list_students.php");
exit;
?>