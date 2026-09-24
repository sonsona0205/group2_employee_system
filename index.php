<?php
require "db.php";

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
            <div class="row align-items-center g-4">
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

    <main class="container my-4">
        <div class="content-panel">
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
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($employee = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $employee["id"] ?></td>

                                    <td>
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
                                        <a href="edit.php?id=<?= $employee["id"] ?>"
                                            class="btn btn-blue btn-sm">
                                            Edit
                                        </a>

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
