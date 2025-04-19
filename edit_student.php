<?php
include('db.php'); // Include the database connection file

// Check if the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $id = $_POST['student_id']; // Get student ID from hidden input field
    $name = $_POST['name']; // Get name from form
    $roll = $_POST['roll_number']; // Get roll number from form

    // Prepare the SQL query to update the student data
    $stmt = $conn->prepare("UPDATE students SET name = ?, roll_number = ? WHERE student_id = ?");
    $stmt->bind_param("ssi", $name, $roll, $id); // Bind the parameters (string, string, integer)

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "Student updated successfully."; // Success message
    } else {
        echo "Error: " . $conn->error; // Error message if the query fails
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
    exit; // Exit after the POST request is handled
}

// Get the student ID from the URL (GET method)
$id = $_GET['id']; 
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id); // Bind the student ID to the query (integer)
$stmt->execute(); // Execute the query
$result = $stmt->get_result(); // Get the result set from the query
$student = $result->fetch_assoc(); // Fetch the student data as an associative array
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
  <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
  <h2>Edit Student</h2>
  <!-- Create a form to edit student information -->
  <form method="POST">
    <!-- Hidden input field to store student ID for form submission -->
    <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">

    <!-- Input fields for student name and roll number with pre-filled values -->
    <input type="text" name="name" value="<?= $student['name'] ?>" required> <!-- Pre-fill name -->
    <input type="text" name="roll_number" value="<?= $student['roll_number'] ?>" required> <!-- Pre-fill roll number -->

    <!-- Submit button to update student information -->
    <button type="submit">Update Student</button>
  </form>
</body>
</html>
