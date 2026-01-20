<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "user") {
    header("Location: ../login.php");
    exit();
}
require "../config/database.php";

$user_id = $_SESSION["user"]["id"];
$stmt = $conn->prepare("SELECT * FROM submissions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Submissions</title>
<style>
body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#1f7a5c;}
.navbar .brand{color:white;font-weight:bold;font-size:20px;}
.navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;transition:.3s;}
.navbar .links a:hover{color:#d1f2e5;}
.container{padding:40px;max-width:900px;margin:30px auto;background:white;border-radius:16px;box-shadow:0 10px 25px rgba(0,0,0,.1);}
h2{text-align:center;color:#1f7a5c;margin-bottom:25px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th, td{padding:12px;border-bottom:1px solid #ccc;text-align:left;}
th{background:#1f7a5c;color:white;}
tr:hover{background:#f1f5f9;}
.status-pending{color:#d97706;font-weight:bold;}
.status-collected{color:#15803d;font-weight:bold;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management</div>
    <div class="links">
        <a href="dashboard_user.php">Dashboard</a>
        <a href="my_submissions.php" class="active">My Submissions</a>
        <a href="../profile.php">Profile</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>My E-Waste Submissions</h2>

    <?php if(count($submissions) > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Location</th>
            <th>Condition</th>
            <th>Status</th>
            <th>Submitted At</th>
        </tr>
        <?php foreach($submissions as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['item_name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['item_condition']) ?></td>
            <td class="<?= strtolower($row['status'])=='pending'?'status-pending':'status-collected' ?>"><?= $row['status'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No submissions yet. <a href="submit.php">Submit one now</a>.</p>
    <?php endif; ?>
</div>

</body>
</html>
