<!DOCTYPE html>
<html>
<head>
  <title>Mark Attendance</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Mark Attendance</h2>

  <?php
  include('db.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['attendance_date'];
    $status = $_POST['status'];

    foreach ($status as $student_id => $att_status) {
      $check = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? AND date = ?");
      $check->bind_param("is", $student_id, $date);
      $check->execute();
      $result = $check->get_result();

      if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?");
        $update->bind_param("sis", $att_status, $student_id, $date);
        $update->execute();
      } else {
        $insert = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $insert->bind_param("iss", $student_id, $date, $att_status);
        $insert->execute();
      }
    }

    echo "<p style='color:green;'>Attendance marked successfully.</p>";
  }
  ?>

  <form method="POST" action="">
    <label>Select Date:</label>
    <input type="date" name="attendance_date" required>

    <div>
      <h3>Students</h3>

      <?php
      $result = $conn->query("SELECT * FROM students");

      while ($row = $result->fetch_assoc()) {
        echo "<div>
                {$row['name']} ({$row['roll_number']})
                <select name='status[{$row['student_id']}]'>
                  <option value='Present'>Present</option>
                  <option value='Absent'>Absent</option>
                </select>
              </div>";
      }
      ?>
    </div>

    <button type="submit">Submit Attendance</button>
  </form>

</body>
</html>