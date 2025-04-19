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
echo "<h2>Attendance Records</h2>";

echo "<form method='GET'>
        <input type='text' name='search' placeholder='Search by name or roll'>
        <input type='date' name='date'>
        <button type='submit'>Filter</button>
      </form>";

$search = isset($_GET['search']) ? $_GET['search'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$sql = "SELECT s.name, s.roll_number, a.date, a.status
        FROM attendance a
        JOIN students s ON a.student_id = s.student_id
        WHERE 1=1";

if ($search) {
    $sql .= " AND (s.name LIKE '%$search%' OR s.roll_number LIKE '%$search%')";
}

if ($date) {
    $sql .= " AND a.date = '$date'";
}

$sql .= " ORDER BY a.date DESC";

$result = $conn->query($sql);

echo "<table border='1'>
        <tr>
          <th>Date</th>
          <th>Name</th>
          <th>Roll Number</th>
          <th>Status</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['date']}</td>
            <td>{$row['name']}</td>
            <td>{$row['roll_number']}</td>
            <td>{$row['status']}</td>
          </tr>";
}

echo "</table>";
?>
