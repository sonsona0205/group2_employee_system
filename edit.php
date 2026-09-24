<?php
require "db.php";

$message = "";
$id = (int) ($_GET["id"] ?? 0);

$stmt = mysqli_prepare($conn, "SELECT * FROM employees WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    exit("Employee not found. <a href='index.php'>Back to employee list</a>");
}

$full_name = $employee["full_name"];
$position = $employee["position"];
$email = $employee["email"];
$department = $employee["department"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"] ?? "");
    $position = trim($_POST["position"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $department = trim($_POST["department"] ?? "");

    if ($full_name == "" || $position == "" || $email == "" || $department == "") {
        $message = "Please complete all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } else {
        $sql = "UPDATE employees
                SET full_name = ?, position = ?, email = ?, department = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $full_name,
            $position,
            $email,
            $department,
            $id
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
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Employee</h1>
        <p>All fields are required.</p>

        <?php if ($message != ""): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="edit.php?id=<?= $id ?>" method="POST">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" id="full_name" name="full_name"
                    class="form-control" maxlength="100"
                    value="<?= htmlspecialchars($full_name) ?>" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" id="position" name="position"
                    class="form-control" maxlength="100"
                    value="<?= htmlspecialchars($position) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                    class="form-control" maxlength="100"
                    value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" id="department" name="department"
                    class="form-control" maxlength="100"
                    value="<?= htmlspecialchars($department) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>

</html>
