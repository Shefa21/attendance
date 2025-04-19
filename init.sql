CREATE DATABASE IF NOT EXISTS attendance_db; -- Creates a database named 'attendance_db' if it does not already exist.
USE attendance_db; -- Switches to the 'attendance_db' database for creating tables and other operations.

-- Create the 'students' table.
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY, -- Creates an auto-incrementing 'student_id' column as the primary key.
    name VARCHAR(50) NOT NULL, -- Creates a 'name' column for storing student names, with a maximum length of 50 characters. It cannot be NULL.
    roll_number VARCHAR(20) UNIQUE -- Creates a 'roll_number' column for storing the student's roll number. It must be unique across the table.
);

-- Create the 'attendance' table.
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY, -- Creates an auto-incrementing 'attendance_id' column as the primary key.
    student_id INT, -- Creates a 'student_id' column to reference a student from the 'students' table.
    date DATE NOT NULL, -- Creates a 'date' column to store the attendance date. It cannot be NULL.
    status ENUM('Present', 'Absent') NOT NULL, -- Creates a 'status' column that can only have values 'Present' or 'Absent'. It cannot be NULL.
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE -- Establishes a foreign key relationship with the 'students' table. If a student is deleted, their attendance records will also be deleted.
);
/*
-- Create a database if it does not exist
CREATE DATABASE IF NOT EXISTS database_name;

-- Select the database to use
USE database_name;

-- Create a table with columns and constraints
CREATE TABLE table_name (
    column_name data_type [constraints],  -- Define a column with a specific data type and optional constraints
    ...
);

-- Auto-increment primary key for a column
column_name INT AUTO_INCREMENT PRIMARY KEY;

-- Define a NOT NULL constraint for a column
column_name data_type NOT NULL;

-- Define a UNIQUE constraint for a column
column_name data_type UNIQUE;

-- Create an ENUM type column with limited values
column_name ENUM('value1', 'value2', ...) NOT NULL;

-- Foreign key constraint to reference another table
FOREIGN KEY (column_name) REFERENCES referenced_table(referenced_column) 
    [ON DELETE CASCADE | ON UPDATE CASCADE | ...];

-- Create a foreign key with cascading delete (delete rows from the child table when the parent row is deleted)
FOREIGN KEY (column_name) REFERENCES referenced_table(referenced_column) ON DELETE CASCADE;
*/