<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$menu = [
    "Momo" => 150,
    "Pizza" => 450,
    "Popcorn" => 120,
    "Mohito" => 180,
    "Burger" => 250,
    "Chowmein" => 160,
    "Coffee" => 100,
    "Cheese Cake" => 300
];

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["customer_name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $salary = $_POST["salary"];
    $selected_items = $_POST["items"] ?? [];

    $items_text = "";
    $total = 0;

    foreach ($selected_items as $item) {
        if (isset($menu[$item])) {
            $items_text .= $item . " - Rs. " . $menu[$item] . "\n";
            $total += $menu[$item];
        }
    }

    $stmt = $conn->prepare("UPDATE orders SET 
        customer_name = ?, 
        address = ?, 
        phone = ?, 
        salary = ?, 
        items = ?, 
        total_amount = ?
        WHERE id = ?");

    $stmt->execute([$name, $address, $phone, $salary, $items_text, $total, $id]);

    header("Location: index.php");
    exit;
}

$current_items = $order["items"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Restaurant Order</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #fff7ed;
        }

        .container {
            width: 650px;
            margin: 40px auto;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.12);
        }

        h2 {
            text-align: center;
            color: #7f1d1d;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        textarea {
            height: 80px;
        }

        .menu-box {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .item {
            background: #fff1e6;
            padding: 13px;
            border-radius: 8px;
            border: 1px solid #fed7aa;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #7f1d1d;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .back {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #7f1d1d;
            text-decoration: none;
        }

        .total {
            font-size: 22px;
            color: #16a34a;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Update Restaurant Order</h2>

    <form method="POST">
        <input type="text" name="customer_name" value="<?= htmlspecialchars($order["customer_name"]) ?>" required>

        <textarea name="address" required><?= htmlspecialchars($order["address"]) ?></textarea>

        <input type="text" name="phone" value="<?= htmlspecialchars($order["phone"]) ?>" required>

        <input type="number" name="salary" value="<?= htmlspecialchars($order["salary"]) ?>" required>

        <h3>Select Food Items</h3>

        <div class="menu-box">
            <?php foreach ($menu as $item => $price): ?>
                <label class="item">
                    <input 
                        type="checkbox" 
                        name="items[]" 
                        value="<?= $item ?>" 
                        data-price="<?= $price ?>" 
                        onchange="calculateTotal()"
                        <?= strpos($current_items, $item) !== false ? "checked" : "" ?>
                    >
                    <?= $item ?> - Rs. <?= $price ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="total">
            Total: Rs. <span id="totalAmount">0</span>
        </div>

        <button type="submit">Update Order</button>
    </form>

    <a class="back" href="index.php">Back to Dashboard</a>
</div>

<script>
function calculateTotal() {
    let checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    let total = 0;

    checkboxes.forEach(function(box) {
        total += parseInt(box.getAttribute("data-price"));
    });

    document.getElementById("totalAmount").innerText = total;
}

calculateTotal();
</script>

</body>
</html>
