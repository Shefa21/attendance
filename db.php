<?php
$host = 'localhost'; // Set the database host (usually localhost)
$db = 'attendance_db'; // Set the database name (attendance_db)
$user = 'root'; // Set the username for MySQL (usually 'root' in local development)
$pass = ''; // Set the password for MySQL (leave empty if no password is set)

// Create a new connection to the MySQL database using the mysqli class
$conn = new mysqli($host, $user, $pass, $db);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error); // Display an error message if connection fails
}
?>
