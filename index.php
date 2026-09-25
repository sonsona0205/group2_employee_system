<?php
require "db.php";
// Fetch all employees from the database into an associative array called $result, ordered by their ID in ascending order.
$result = mysqli_query($conn, "SELECT * FROM employees ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Registry | Special Fire Force</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <header class="brigade-header">
        <div class="container">
            <!-- g-4 means "gutters" with a spacing of 4 units between the columns in the Bootstrap grid system. It is used to create consistent spacing between elements in a row. -->
            <div class="row align-items-center g-4">
                <!-- This is a column that takes up 7 out of 12 columns on medium screens and larger -->
                <div class="col-md-7">
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
    <!-- my-4 means "margin-top and margin-bottom" with a spacing of 4 units. It is used to create consistent spacing around the main content area. -->
    <main class="container my-4">
        <div class="content-panel">
            <!-- d-flex means "display flex", flex-wrap means the elements will wrap to the next line if they don't fit, 
            justify-content-between means the elements will be spaced out evenly with the first element at the start and the last element at the end,
            align-items-center means the elements will be aligned in the center vertically,
            gap-3 means there will be a gap of 3 units between the elements. -->
            <div class="d-flex flex-wrap justify-content-between
                        align-items-center gap-3 mb-4">
                <div>
                    <h2 class="section-title">Personnel Roster</h2>
                    <p class="section-note mb-0">
                        Manage personnel records across all Fire Force companies.
                    </p>
                </div>

                <a href="add.php" class="btn btn-fire">
                    + Add Personnel
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered
                              align-middle employee-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Brigade Role</th>
                            <th>Email</th>
                            <th>Company / Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- The conditional logic to display employee data -->
                        <!-- If there are employees in the result set, display them -->
                        <!-- basically, it fetches each row as an associative array and assigns it to $employee -->
                        <!-- so we created $employee to hold the data for each employee
                             so we can access the data for each employee using the $employee variable -->
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($employee = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $employee["id"] ?></td>

                                    <td>
                                        <!-- htmlspecialchars() is used to convert special characters to HTML entities -->
                                        <?= htmlspecialchars($employee["full_name"]) ?>
                                    </td>

                                    <td>
                                        <span class="role-badge">
                                            <?= htmlspecialchars($employee["position"]) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($employee["email"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($employee["department"]) ?>
                                    </td>

                                    <td class="actions">
                                        <!-- ?id=<?= $employee["id"] ?> because we want to pass the employee's ID to the edit page -->
                                        <!-- so we can edit the correct employee -->
                                        <a href="edit.php?id=<?= $employee["id"] ?>"
                                            class="btn btn-blue btn-sm">
                                            Edit
                                        </a>

                                        <!-- The form is used to delete an employee -->
                                        <!-- The hidden input field is used to pass the employee's ID to the delete page -->
                                        <!-- so we can delete the correct employee -->
                                        <!-- class="d-inline" makes the form display inline -->
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
                                <!-- colspan="6" means the cell spans 6 columns -->
                                <!-- py-4 means padding on the top and bottom -->
                                <td colspan="6" class="text-center py-4">
                                    No personnel registered.
                                    Click Add Personnel to begin.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        GROUP 2 &bull; FIRE FORCE–INSPIRED EMPLOYEE RECORDS
    </footer>
</body>

</html>
