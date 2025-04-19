<!DOCTYPE html>
<html>
<head>
  <title>Mark Attendance</title> <!-- Page Title -->
  <link rel="stylesheet" href="style.css"> <!-- External CSS -->
</head>
<body>
  <h2>Mark Attendance</h2> <!-- Main heading -->

  <?php
  // Include database connection file
  include('db.php');

  // Check if the form has been submitted via POST
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve submitted date and attendance status array
    $date = $_POST['attendance_date'];
    $status = $_POST['status']; // status is an associative array: [student_id => 'Present'/'Absent']

    // Loop through each student’s attendance status
    foreach ($status as $student_id => $att_status) {
      // Check if the attendance record already exists
      $check = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? AND date = ?");
      $check->bind_param("is", $student_id, $date); // i = integer, s = string
      $check->execute();
      $result = $check->get_result();

      if ($result->num_rows > 0) {
        // Record exists - Update the existing attendance record
        $update = $conn->prepare("UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?");
        $update->bind_param("sis", $att_status, $student_id, $date); // s = string, i = integer, s = string
        $update->execute();
      } else {
        // Record does not exist - Insert new attendance entry
        $insert = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $insert->bind_param("iss", $student_id, $date, $att_status);
        $insert->execute();
      }
    }

    // Show success message
    echo "<p style='color:green;'>Attendance marked successfully.</p>";
  }
  ?>

  <!-- Attendance Form -->
  <form method="POST" action="">
    <!-- Select date -->
    <label>Select Date:</label>
    <input type="date" name="attendance_date" required>

    <!-- Student Attendance Section -->
    <div>
      <h3>Students</h3>

      <?php
      // Fetch all students to display in the form
      $result = $conn->query("SELECT * FROM students");

      // Loop through students and generate attendance dropdown
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

    <!-- Submit button -->
    <button type="submit">Submit Attendance</button>
  </form>

</body>
</html>
