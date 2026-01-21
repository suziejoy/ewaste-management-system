<?php
require "config/database.php";

$stmt = $conn->query("SELECT submissions.*, users.fullname FROM submissions JOIN users ON submissions.user_id = users.id ORDER BY created_at DESC");
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Public E-Waste Submissions</title>
<style>
body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f4f4;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#1f7a5c;}
.navbar .brand{color:white;font-weight:bold;font-size:20px;}
.navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;transition:.3s;}
.navbar .links a:hover{color:#d1f2e5;}
.container{padding:40px;max-width:1000px;margin:30px auto;}
h1,h2{text-align:center;color:#1f7a5c;}
table{width:100%;border-collapse:collapse;margin-top:20px;background:white;border-radius:12px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,.1);}
th, td{padding:12px;border-bottom:1px solid #ccc;text-align:left;}
th{background:#1f7a5c;color:white;}
tr:hover{background:#f1f5f9;}
.status-pending{color:#d97706;font-weight:bold;}
.status-collected{color:#15803d;font-weight:bold;}
.btn-signup{display:inline-block;margin:20px auto;text-decoration:none;padding:10px 25px;background:#1f7a5c;color:white;border-radius:6px;font-weight:bold;transition:.2s;}
.btn-signup:hover{background:#259c5d;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management - Let's Go Green 🌍</div>
    <div class="links">
        <a href="index.php">Home</a>
        <a href="user_signup.php">Sign Up</a>
    </div>
</div>

<div class="container">
    <h1>Public E-Waste Submissions</h1>
    <h2>See how our community is contributing and get inspired!</h2>

    <?php if(count($submissions) > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Item</th>
            <th>Location</th>
            <th>Condition</th>
            <th>Description</th>
            <th>Status</th>
            <th>Submitted At</th>
        </tr>
        <?php foreach($submissions as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['item_name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['item_condition']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td class="<?= strtolower($row["status"])=='pending'?'status-pending':'status-collected' ?>"><?= $row["status"] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No submissions yet. Be the first to <a href="user_signup.php" class="btn-signup">Sign Up</a> and contribute!</p>
    <?php endif; ?>
</div>

</body>
</html>
