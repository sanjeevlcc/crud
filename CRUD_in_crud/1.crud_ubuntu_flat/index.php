<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$stmt = $conn->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Order Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #fff7ed;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #7f1d1d, #ea580c);
            color: white;
            padding: 25px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
        }

        .header a {
            color: white;
            text-decoration: none;
            background: #111827;
            padding: 10px 18px;
            border-radius: 8px;
        }

        .container {
            width: 95%;
            margin: 35px auto;
        }

        .top-btn {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: #7f1d1d;
            color: white;
            padding: 14px;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        tr:hover {
            background: #fff1e6;
        }

        .edit {
            background: #f59e0b;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        .delete {
            background: #dc2626;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        .items {
            text-align: left;
            line-height: 1.8;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🍕 Restaurant Order CRUD Dashboard</h1>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

    <a href="create.php" class="top-btn">+ Add New Order</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone No</th>
            <th>Salary</th>
            <th>Selected Items</th>
            <th>Total Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order["id"] ?></td>
            <td><?= htmlspecialchars($order["customer_name"]) ?></td>
            <td><?= htmlspecialchars($order["address"]) ?></td>
            <td><?= htmlspecialchars($order["phone"]) ?></td>
            <td>Rs. <?= number_format($order["salary"], 2) ?></td>
            <td class="items"><?= nl2br(htmlspecialchars($order["items"])) ?></td>
            <td><b>Rs. <?= number_format($order["total_amount"], 2) ?></b></td>
            <td><?= $order["created_at"] ?></td>
            <td>
                <a class="edit" href="update.php?id=<?= $order["id"] ?>">Edit</a>
                <a class="delete" href="delete.php?id=<?= $order["id"] ?>" onclick="return confirm('Delete this order?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
