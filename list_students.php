<?php
include('db.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Students</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>All Students</h2>
<a href="student_form.html">+ Add Student</a><br><br>

<?php
$result = $conn->query("SELECT * FROM students");

echo "<table>
<tr><th>Name</th><th>Roll Number</th><th>Actions</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['roll_number']}</td>
            <td>
              <a href='edit_student.php?id={$row['student_id']}'>Edit</a> |
              <a href='delete_student.php?id={$row['student_id']}' onclick=\"return confirm('Delete this student?')\">Delete</a>
            </td>
          </tr>";
}

echo "</table>";
?>

</body>
</html>
