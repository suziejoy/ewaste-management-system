<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "user") {
    header("Location: ../login.php");
    exit();
}

$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
        .navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#1f7a5c;}
        .navbar .brand{color:white;font-weight:bold;font-size:20px;}
        .navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;transition:.3s;}
        .navbar .links a:hover{color:#d1f2e5;}
        .navbar .links .active{border-bottom:2px solid #d1f2e5;}
        .container{padding:40px;max-width:900px;margin:30px auto;}
        h2{text-align:center;color:#1f7a5c;margin-bottom:25px;}
        .cards{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;}
        .card{background:white;padding:30px 20px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.1);width:250px;text-align:center;transition:transform 0.3s,box-shadow 0.3s;}
        .card:hover{transform:translateY(-8px);box-shadow:0 8px 25px rgba(0,0,0,0.2);}
        .card a{display:inline-block;margin-top:15px;padding:10px 20px;background:#1f7a5c;color:white;border-radius:6px;text-decoration:none;font-weight:bold;transition:.2s;}
        .card a:hover{background:#259c5d;}
    </style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management</div>
    <div class="links">
        <a href="../index.php">Home</a>
        <a href="dashboard_user.php" class="active">Dashboard</a>
        <a href="submit.php">Submit</a>
        <a href="my_submissions.php">My Submissions</a>
        <a href="../profile.php">My Profile</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user["fullname"]) ?>!</h2>

    <div class="cards">
        <div class="card">
            <h3>Submit E-Waste</h3>
            <p>Submit your old electronics for recycling.</p>
            <a href="submit.php">Submit</a>
        </div>

        <div class="card">
            <h3>My Submissions</h3>
            <p>View all items you have submitted.</p>
            <a href="my_submissions.php">View</a>
        </div>
    </div>
</div>

</body>
</html>
