<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $roll = $_POST['roll_number'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, roll_number = ? WHERE student_id = ?");
    $stmt->bind_param("ssi", $name, $roll, $id);

    if ($stmt->execute()) {
        echo "Student updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Edit Student</h2>
  <form method="POST">
    <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">
    <input type="text" name="name" value="<?= $student['name'] ?>" required>
    <input type="text" name="roll_number" value="<?= $student['roll_number'] ?>" required>
    <button type="submit">Update Student</button>
  </form>
</body>
</html>