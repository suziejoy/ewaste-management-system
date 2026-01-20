<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
require "config/database.php";

$user = $_SESSION["user"];
$message = "";
$error = "";

// Update profile
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_profile"])) {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);

    if (!empty($_POST["password"])) {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, password=? WHERE id=?");
        $stmt->execute([$fullname, $email, $password, $user["id"]]);
    } else {
        $stmt = $conn->prepare("UPDATE users SET fullname=?, email=? WHERE id=?");
        $stmt->execute([$fullname, $email, $user["id"]]);
    }

    $_SESSION["user"]["fullname"] = $fullname;
    $_SESSION["user"]["email"] = $email;
    $message = "Profile updated successfully!";
}

// Delete account
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_account"])) {
    if ($user["role"] === "user") {
        $stmt = $conn->prepare("DELETE FROM submissions WHERE user_id=?");
        $stmt->execute([$user["id"]]);
    }
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$user["id"]]);
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<style>
body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#1f7a5c;}
.navbar .brand{color:white;font-weight:bold;font-size:20px;}
.navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;transition:.3s;}
.navbar .links a:hover{color:#d1f2e5;}
.container{padding:40px;max-width:500px;margin:30px auto;background:white;border-radius:16px;box-shadow:0 10px 25px rgba(0,0,0,.1);}
h2{text-align:center;color:#1f7a5c;margin-bottom:25px;}
form{display:flex;flex-direction:column;gap:15px;}
input{padding:10px;border-radius:6px;border:1px solid #ccc;width:100%;}
button{padding:12px;background:#1f7a5c;color:white;font-weight:bold;border:none;border-radius:6px;cursor:pointer;transition:.2s;}
button:hover{background:#259c5d;}
.delete-btn{background:#d13434;}
.delete-btn:hover{background:#a32424;}
.message{color:#15803d;font-weight:bold;text-align:center;}
.error{color:#d13434;font-weight:bold;text-align:center;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management</div>
    <div class="links">
        <?php if($user['role']=='user'): ?>
            <a href="user/dashboard_user.php">Dashboard</a>
        <?php else: ?>
            <a href="admin/dashboard_admin.php">Dashboard</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>My Profile</h2>

    <?php if($message) echo "<div class='message'>$message</div>"; ?>
    <?php if($error) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="hidden" name="update_profile" value="1">
        <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <button type="submit">Update Profile</button>
    </form>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');" style="margin-top:20px;">
        <input type="hidden" name="delete_account" value="1">
        <button type="submit" class="delete-btn">Delete Account</button>
    </form>
</div>

</body>
</html>
