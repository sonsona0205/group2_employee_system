<?php
require "db.php";

$message = "";
$full_name = "";
$position = "";
$email = "";
$department = "";

// Handle form submission
// basically, if the request method is POST, we retrieve the form data, validate it,
// and insert it into the database if everything is valid. 
// If there are any validation errors, we set an error message to be displayed to the user.
// $_Server["REQUEST_METHOD"] is a superglobal variable in PHP that contains information about the request method used to access the page (e.g., GET, POST, etc.).
// trim() is a PHP function that removes whitespace from the beginning and end of a string. It is used here to clean up the input data before validation and insertion into the database.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"] ?? "");
    $position = trim($_POST["position"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($full_name == "" || $position == "" || $email == "" || $department == "") {
        $message = "Please complete all required fields.";
        // !filter_var($email, FILTER_VALIDATE_EMAIL) is a PHP function that checks if the provided email address is valid according to standard email format rules. 
        // If the email is not valid, it sets an error message to inform the user.
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else {
        // (values (?, ?, ?, ?)) is a placeholder for the actual values that will be inserted into the database.
        // why use prepared statements? Prepared statements are used to prevent SQL injection attacks by separating the SQL code from the data being inserted.
        $sql = "INSERT INTO employees (full_name, position, email, department)
                VALUES (?, ?, ?, ?)";
        // explain below upto mysqli_stmt_execute($stmt);
        // mysqli_prepare($conn, $sql) prepares the SQL statement for execution. It returns a statement object that can be used to bind parameters and execute the query.
        // mysqli_stmt_bind_param($stmt, "ssss", $full_name, $position, $email, $department) binds the actual values to the placeholders in the prepared statement. The "ssss" indicates that all four parameters are strings.
        // mysqli_stmt_execute($stmt) executes the prepared statement with the bound parameters, inserting the data into the database.
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $full_name,
            $position,
            $email,
            $department
        );
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Add Personnel | Special Fire Force
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header class="brigade-header">
        <!-- use container when you want to center the content and add some padding -->
        <div class="container">
            <!-- g-4 adds a 1rem margin on all sides of the grid items. 1rem meaning 16px -->
            <div class="row align-items-center g-4">
                <div class="col-md-7">
                    <!-- span is used to display a small text element, typically for labels or badges -->
                    <span class="company-badge">PERSONNEL REGISTRY</span>
                    <h1>SPECIAL FIRE FORCE</h1>
                    <p>Employee Records System | All Companies</p>
                </div>

                <div class="col-md-5">
                    <img src="images/fire-force-logo.webp"
                        alt="Fire Force"
                        class="header-logo">
                </div>
            </div>
        </div>
    </header>
    <!-- my-4 adds a 1rem margin on the top and bottom of the element. 1rem meaning 16px -->
    <main class="container my-4">
        <div class="row justify-content-center">
            <!-- col-lg-8 centers the content and sets the width to 8 columns on large screens -->
            <div class="col-lg-8">
                <div class="content-panel">
                    <h2 class="section-title">
                        Add Personnel
                    </h2>
                    <p class="section-note">
                        Enter the employee's brigade details.
                        All fields are required.
                    </p>
                    <!-- if $message is not empty, display an error message -->
                    <?php if ($message != ""): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">
                                Full Name
                            </label>
                            <!-- the value="..." sets the initial value of the input field if $full_name is not empty -->
                            <input type="text"
                                id="full_name"
                                name="full_name"
                                class="form-control"
                                maxlength="100"
                                placeholder="Example: Shinra Kusakabe"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">
                                Brigade Role
                            </label>

                            <input type="text"
                                id="position"
                                name="position"
                                class="form-control"
                                maxlength="100"
                                placeholder="Example: Fire Soldier"
                                required>

                            <div class="form-text">
                                Examples: Captain, Lieutenant, Fire Soldier,
                                or Engineer.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                maxlength="100"
                                placeholder="Example: shinra@example.com"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="department" class="form-label">
                                Company / Department
                            </label>

                            <input type="text"
                                id="department"
                                name="department"
                                class="form-control"
                                maxlength="100"
                                placeholder="Example: Special Fire Force Company 8"
                                required>
                        </div>

                        <button type="submit" class="btn btn-fire">
                            Save Personnel
                        </button>

                        <a href="index.php" class="btn btn-back">
                            Back to Roster
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        GROUP 2 &bull; FIRE FORCE–INSPIRED EMPLOYEE RECORDS
    </footer>
</body>

</html>
