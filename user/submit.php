<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "user") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";

$message = "";

// Handle submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_item'])) {
    $user_id = $_SESSION["user"]["id"];
    $item_name = $_POST["item_name"];
    $location = trim($_POST["location"]);
    $item_condition = $_POST["item_condition"];
    $description = trim($_POST["description"]);
    $status = "pending";

    $stmt = $conn->prepare(
        "INSERT INTO submissions (user_id, item_name, location, item_condition, description, status)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$user_id, $item_name, $location, $item_condition, $description, $status]);

    $message = "Submission successful!";
}

// Handle cancel/delete of latest pending submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_item'])) {
    $user_id = $_SESSION["user"]["id"];

    // Delete the most recent pending submission
    $stmt = $conn->prepare(
        "DELETE FROM submissions WHERE id = (
            SELECT id FROM submissions 
            WHERE user_id = ? AND status = 'pending' 
            ORDER BY created_at DESC LIMIT 1
        )"
    );
    $stmt->execute([$user_id]);

    $message = "Your pending submission was cancelled.";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submit E-Waste</title>
<style>
body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
.navbar{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#1f7a5c;}
.navbar .brand{color:white;font-weight:bold;font-size:20px;}
.navbar .links a{color:white;margin-left:20px;text-decoration:none;font-weight:600;}
.navbar .links a:hover{color:#d1f2e5;}
.container{padding:40px;max-width:500px;margin:30px auto;background:white;border-radius:16px;box-shadow:0 10px 25px rgba(0,0,0,.1);}
h2{text-align:center;color:#1f7a5c;}
form{display:flex;flex-direction:column;gap:15px;}
input, select, textarea{padding:10px;border-radius:6px;border:1px solid #ccc;}
button{padding:12px;background:#1f7a5c;color:white;font-weight:bold;border:none;border-radius:6px;cursor:pointer;transition:.2s;}
button:hover{background:#259c5d;}
button.delete{background:#dc2626;margin-top:5px;}
button.delete:hover{background:#b91c1c;}
.message{text-align:center;color:#15803d;font-weight:bold;margin-bottom:15px;}
</style>
</head>
<body>

<div class="navbar">
    <div class="brand">E-Waste Management</div>
    <div class="links">
        <a href="dashboard_user.php">Dashboard</a>
        <a href="my_submissions.php">My Submissions</a>
        <a href="../profile.php">Profile</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Submit E-Waste</h2>

    <?php if($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <select name="item_name" required>
            <option value="">Select Item</option>
            <option value="Phone">Phone</option>
            <option value="Television">Television</option>
            <option value="Battery">Battery</option>
            <option value="Monitor">Monitor</option>
            <option value="Other">Other</option>
        </select>

        <input type="text" name="location" placeholder="Location" required>

        <select name="item_condition" required>
            <option value="Good">Good</option>
            <option value="Poor">Poor</option>
            <option value="Broken">Broken</option>
        </select>

        <textarea name="description" placeholder="Description" rows="4"></textarea>

        <button type="submit" name="submit_item">Submit</button>
        <button type="submit" name="delete_item" class="delete" 
            onclick="return confirm('Are you sure you want to cancel your pending submission?');">
            Cancel Submission
        </button>
    </form>
</div>

</body>
</html>
