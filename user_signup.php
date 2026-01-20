<?php
require __DIR__ . '/config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'user')"
    );
    $stmt->execute([$name, $email, $password]);

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Sign Up</title>
<style>
body{margin:0;height:100vh;display:flex;align-items:center;justify-content:center;font-family:Segoe UI;background:#f4f6f5;}
.card{background:#fff;width:400px;padding:40px;border-radius:16px;box-shadow:0 15px 35px rgba(0,0,0,.12);}
.brand{text-align:center;margin-bottom:25px;}
.brand h1{margin:0;color:#1f7a5c;}
.brand p{margin:6px 0 0;font-size:14px;color:#666;font-style:italic;}
h2{margin-top:30px;color:#333;}
input{width:100%;padding:12px;margin-bottom:15px;border-radius:8px;border:1px solid #ccc;}
button{width:100%;padding:12px;background:#1f7a5c;color:white;border:none;border-radius:8px;font-size:16px;cursor:pointer;}
.links{margin-top:18px;text-align:center;}
.links a{display:block;color:#1f7a5c;text-decoration:none;font-weight:600;margin-top:8px;}
</style>
</head>
<body>

<div class="card">
    <div class="brand">
        <h1>E-Waste Management</h1>
       <p>Let’s go green and care for our planet 🌍</p>
    </div>

    <h2>User Sign Up</h2>

    <form method="POST">
        <input name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Create Account</button>
    </form>

    <div class="links">
        <a href="login.php">Already have an account? Login</a>
        <a href="index.php">← Back to Landing Page</a>
    </div>
</div>

</body>
</html>
