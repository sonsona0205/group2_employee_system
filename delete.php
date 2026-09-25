<?php
require "db.php";
// Check if the request method is POST, which indicates that the form has been submitted. If it is, retrieve the employee ID from the POST data, prepare a SQL statement to delete the employee with that ID from the database, bind the ID parameter to the statement, and execute it. After deleting the employee, redirect back to index.php and exit the script.    
// $id = (int) ($_POST["id"] ?? 0); retrieves the employee ID from the POST data. If the "id" parameter is not present in the POST data, it defaults to 0. The (int) cast ensures that the value is treated as an integer.
// if 0 it just returns to index.php without performing any deletion, as there is no employee with ID 0. This prevents accidental deletion of unintended records.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) ($_POST["id"] ?? 0);

    $stmt = mysqli_prepare($conn, "DELETE FROM employees WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;
