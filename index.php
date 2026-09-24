<?php
require "db.php";

$result = mysqli_query($conn, "SELECT * FROM employees ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Employee Records</h1>

        <a href="add.php" class="btn btn-primary mb-3">Add Employee</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($employee = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $employee["id"] ?></td>
                                <td><?= htmlspecialchars($employee["full_name"]) ?></td>
                                <td><?= htmlspecialchars($employee["position"]) ?></td>
                                <td><?= htmlspecialchars($employee["email"]) ?></td>
                                <td><?= htmlspecialchars($employee["department"]) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $employee["id"] ?>"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="delete.php" method="POST"
                                        class="d-inline">
                                        <input type="hidden" name="id"
                                            value="<?= $employee["id"] ?>">
                                        <button type="submit"
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                No employee records yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
