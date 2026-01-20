<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}
require "../config/database.php";

// Handle status update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submission_id = $_POST["submission_id"];
    $new_status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE submissions SET status=? WHERE id=?");
    $stmt->execute([$new_status, $submission_id]);
}

// Fetch submissions
$result = $conn->query("SELECT submissions.*, users.fullname FROM submissions JOIN users ON submissions.user_id = users.id ORDER BY submissions.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Submissions</title>
<style>
/* keep same CSS as before */
body{margin:0;font-family:Segoe UI, sans-serif;background:#f3f4f6;color:#1f2933;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:16px 40px;background:#1f2933;}
.brand{color:white;font-size:20px;font-weight:700;}
.links a{color:#d1d5db;margin-left:24px;text-decoration:none;font-weight:600;transition:.2s;}
.links a:hover{color:white;}
.container{max-width:1100px;margin:40px auto;background:white;padding:32px;border-radius:14px;box-shadow:0 10px 25px rgba(0,0,0,.08);}
h2{text-align:center;margin-bottom:25px;color:#1f2933;}
table{width:100%;border-collapse:collapse;}
th, td{padding:14px;border-bottom:1px solid #e5e7eb;text-align:left;}
th{background:#f9fafb;font-size:14px;text-transform:uppercase;letter-spacing:.5px;color:#374151;}
tr:hover{background:#f9fafb;}
.pending{color:#b45309;font-weight:700;}
.collected{color:#047857;font-weight:700;}
select{padding:6px 10px;border-radius:6px;border:1px solid #d1d5db;background:white;}
button{padding:6px 14px;margin-left:8px;border:none;border-radius:6px;background:#2f855a;color:white;font-weight:600;cursor:pointer;transition:.2s;}
button:hover{background:#276749;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Admin Panel</div>
    <div class="links">
        <a href="dashboard_admin.php">Dashboard</a>
        <a href="manage_submissions.php">Manage Submissions</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Manage E-Waste Submissions</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Item</th>
            <th>Location</th>
            <th>Condition</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["fullname"]) ?></td>
            <td><?= htmlspecialchars($row["item_name"]) ?></td>
            <td><?= htmlspecialchars($row["location"]) ?></td>
            <td><?= htmlspecialchars($row["item_condition"]) ?></td>
            <td class="<?= strtolower($row["status"]) ?>"><?= $row["status"] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="submission_id" value="<?= $row["id"] ?>">
                    <select name="status">
                        <option value="pending" <?= $row["status"]=="pending"?"selected":"" ?>>Pending</option>
                        <option value="collected" <?= $row["status"]=="collected"?"selected":"" ?>>Collected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
