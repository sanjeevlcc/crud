<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
require 'db.php';
$stmt = $conn->query("SELECT * FROM employees");
$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Employee List</h2>
        <a href="create.php" class="btn btn-success mb-3">Add New Employee</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee['id'] ?></td>
                    <td><?= $employee['name'] ?></td>
                    <td><?= $employee['email'] ?></td>
                    <td><?= $employee['mobile'] ?></td>
                    <td><?= $employee['gender'] ?></td>
                    <td><?= $employee['address'] ?></td>
                    <td><?= $employee['salary'] ?></td>
                    <td><img src="uploads/<?= $employee['image'] ?>" width="50"></td>
                    <td>
                        <a href="update.php?id=<?= $employee['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $employee['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
