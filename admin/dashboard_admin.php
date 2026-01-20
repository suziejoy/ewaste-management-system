<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    header("Location: ../login.php");
    exit();
}
require "../config/database.php";
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{margin:0;font-family:Segoe UI, sans-serif;background:#e5e7eb;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#111827;}
.navbar .brand{color:white;font-weight:bold;font-size:20px;}
.navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;transition:.3s;}
.navbar .links a:hover{color:#9ca3af;}
.navbar .links .active{border-bottom:2px solid #9ca3af;}
.container{padding:40px;max-width:900px;margin:auto;}
.cards{display:flex;gap:30px;flex-wrap:wrap;}
.card{flex:1 1 250px;padding:30px;background:white;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1);transition:.3s;text-align:center;}
.card:hover{transform:translateY(-8px);box-shadow:0 8px 25px rgba(0,0,0,.2);}
.card a{display:block;margin-top:20px;text-decoration:none;color:#fff;background:#111827;padding:10px 20px;border-radius:8px;font-weight:600;}
.card a:hover{background:#374151;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management</div>
    <div class="links">
        <a href="../index.php">Home</a>
        <a href="dashboard_admin.php" class="active">Dashboard</a>
        <a href="manage_submissions.php">Manage Submissions</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user["fullname"]) ?> (Admin)</h2>
    <div class="cards">
        <div class="card">
            <h3>Manage Submissions</h3>
            <p>View and update submission statuses.</p>
            <a href="manage_submissions.php">Go</a>
        </div>
        <div class="card">
            <h3>Profile</h3>
            <p>View or edit your profile information.</p>
            <a href="../profile.php">Go</a>
        </div>
    </div>
</div>

</body>
</html>
