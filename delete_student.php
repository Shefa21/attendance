<?php
include('db.php'); // Include the database connection file

// Get the student ID from the URL (GET method)
$id = $_GET['id']; 

// Prepare the SQL query to delete the student with the specified ID
$stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");

// Bind the student ID parameter to the query (integer type)
$stmt->bind_param("i", $id);

// Execute the query and check if it was successful
if ($stmt->execute()) {
    echo "Student deleted."; // Success message
} else {
    echo "Error: " . $conn->error; // Error message if the query fails
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
header("Location: list_students.php");
exit;
?>
