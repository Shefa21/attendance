<?php
// Include the database connection file
include('db.php');

// Get the 'name' from the POST request and remove extra spaces
$name = trim($_POST['name']);

// Get the 'roll_number' from the POST request and remove extra spaces
$roll = trim($_POST['roll_number']);

// Check if both name and roll number are not empty
if (!empty($name) && !empty($roll)) {
    // Prepare an SQL statement to insert data into the students table
    $stmt = $conn->prepare("INSERT INTO students (name, roll_number) VALUES (?, ?)");

    // Bind the parameters to the SQL query ('ss' means two string values)
    $stmt->bind_param("ss", $name, $roll);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // If the execution is successful, display success message
        echo "Student added successfully.";
    } else {
        // If there is an error in execution, display the error message
        echo "Error: " . $conn->error;
    }

    // Close the prepared statement to free resources
    $stmt->close();
} else {
    // If name or roll number is empty, display an error message
    echo "Please fill all fields.";
}

// Close the database connection
$conn->close();
?>

/*
===============================================
🔁 PHP Concepts and Elements Used in This File
===============================================

1. $name, $roll:
   - PHP variables used to store user input from the HTML form.
   - Values come from the $_POST array and are cleaned using trim().

2. $_POST:
   - Superglobal associative array in PHP.
   - Holds data submitted via an HTML form with method="post".
   - Example: $_POST['name'] gets the value from <!--<input name="name">.-->

3. trim():
   - PHP function that removes whitespace from the beginning and end of a string.
   - Useful for cleaning user input.

4. if (!empty(...)):
   - Checks if a variable is not empty.
   - Used here to validate form input before proceeding.

5. $conn:
   - Represents the database connection (created in db.php).
   - Used to interact with the MySQL database using MySQLi.

6. $stmt:
   - Variable holding the statement object created by $conn->prepare().
   - Short for "statement" — a convention used for readability.

7. $conn->prepare("..."):
   - Prepares an SQL query with placeholders (?) to prevent SQL injection.
   - Returns a statement object used for binding and executing.

8. ? (in SQL):
   - Placeholder in the SQL query for parameters.
   - Real values are later bound using bind_param().

9. $stmt->bind_param("ss", $name, $roll):
   - Binds PHP variables to the placeholders in the prepared statement.
   - "ss" indicates both parameters are strings.

10. bind_param() type codes:
    - "s" = string
    - "i" = integer
    - "d" = double (float)
    - "b" = blob (binary)

11. $stmt->execute():
    - Executes the prepared and bound SQL query.

12. $stmt->close():
    - Closes the statement object to free memory.

13. $conn->close():
    - Closes the database connection.

14. echo:
    - PHP keyword used to output text or messages to the screen.

15. include('db.php'):
    - Includes external PHP file that contains database connection logic.
    - Keeps code modular and reusable.
16.-> is called the object operator.Its used to access a property or method of an object.An object is a variable that’s based on a class, and it can have:
Properties (like variables inside it) ,Methods (like functions inside it)
$stmt = $conn->prepare("INSERT INTO students (name, roll_number) VALUES (?, ?)");
$conn is an object that represents the database connection.

prepare() is a method inside that object.

So -> is used to call that method: prepare() on the $conn object.

Same for:
$stmt->bind_param("ss", $name, $roll);
$stmt->execute();
Youre saying: "Hey $stmt, please run your bind_param method."
Then: "Okay $stmt, now execute the query."

17.SQL injection:
   - A security vulnerability where an attacker can manipulate SQL queries.
   - Occurs when user input is not properly sanitized or validated.
 Imagine your PHP code does this (❌ insecure):


$name = $_POST['name'];
$sql = "SELECT * FROM students WHERE name = '$name'";
Now someone enters this into the form:

' OR 1=1 --
So your query becomes:
SELECT * FROM students WHERE name = '' OR 1=1 --'
This trick bypasses login or shows all data, because:
1=1 is always true.

-- tells SQL to ignore the rest.

Scary, right?
This is where bind_param() comes in.

Instead of inserting the user input directly into the query, you write:
$stmt = $conn->prepare("SELECT * FROM students WHERE name = ?");
$stmt->bind_param("s", $name);
Heres why this is safe:

The ? is a placeholder — it says “insert something here later.”

bind_param() tells the database “this is a string, treat it like data, not code.”

So even if someone tries to type ' OR 1=1 --, it will just look for that as a name, not as part of the SQL.

🧠 Summary:
This code securely inserts a student's name and roll number into the database 
using a prepared statement, with input validation and protection against SQL injection.
*/
