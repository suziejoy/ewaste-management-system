<?php
session_start();
require "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user;

        if ($user["role"] === "admin") {
            header("Location: admin/dashboard_admin.php");
        } else {
            header("Location: user/dashboard_user.php");
        }
        exit();
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{margin:0;height:100vh;display:flex;align-items:center;justify-content:center;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
.card{background:#fff;width:400px;padding:40px;border-radius:16px;box-shadow:0 15px 35px rgba(0,0,0,.12);}
.brand{text-align:center;margin-bottom:25px;}
.brand h1{margin:0;color:#1f7a5c;}
.brand p{margin:6px 0 0;font-size:14px;color:#666;font-style:italic;}
h2{margin-top:30px;color:#333;}
input{width:100%;padding:12px;margin-bottom:15px;border-radius:8px;border:1px solid #ccc;}
button{width:100%;padding:12px;background:#1f7a5c;color:white;border:none;border-radius:8px;font-size:16px;cursor:pointer;}
.links{margin-top:18px;text-align:center;}
.links a{display:block;color:#1f7a5c;text-decoration:none;font-weight:600;margin-top:8px;}
.message{color:#d13434;font-weight:bold;text-align:center;margin-bottom:15px;}
</style>
</head>
<body>

<div class="card">
    <div class="brand">
        <h1>E-Waste Management</h1>
        <p>Let’s go green and care for our planet 🌍</p>
    </div>

    <h2>Login</h2>

    <?php if($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="links">
        <a href="user_signup.php">Don't have an account? Sign Up</a>
        <a href="index.php">← Back to Landing Page</a>
    </div>
</div>

</body>
</html>
