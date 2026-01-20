<!DOCTYPE html>
<html>
<head>
    <title>E-Waste Management</title>
    <style>
        body{margin:0;font-family:Segoe UI, sans-serif;background:#f4f6f5;}
        nav{background:#1f7a5c;color:white;padding:20px 50px;}
        nav h1{margin:0;font-size:28px;}
        nav p{margin:5px 0 0;font-size:14px;opacity:.9;}
        .container{text-align:center;padding:70px 20px;}
        .roles{display:flex;justify-content:center;gap:40px;flex-wrap:wrap;margin-top:50px;}
        .card{background:white;width:300px;padding:40px 30px;border-radius:14px;box-shadow:0 8px 25px rgba(0,0,0,.1);transition: transform .3s ease,box-shadow .3s ease;cursor:pointer;}
        .card:hover{transform: translateY(-12px);box-shadow:0 20px 40px rgba(0,0,0,.18);}
        .card h2{color:#1f7a5c;transition:color .3s ease;}
        .card:hover h2{color:#145a43;}
        .card p{color:#555;}
        .btn-group{margin-top:25px;display:flex;justify-content:center;gap:15px;}
        .btn{padding:10px 18px;border-radius:6px;text-decoration:none;font-weight:bold;transition:all .25s ease;}
        .primary{background:#1f7a5c;color:white;}
        .primary:hover{background:#259c5d;}
        .secondary{border:2px solid #1f7a5c;color:#1f7a5c;}
        .secondary:hover{background:#1f7a5c;color:white;}
    </style>
</head>
<body>

<nav>
    <h1>E-Waste Management</h1>
    <p>Let’s go green and care for our planet 🌍</p>
</nav>

<div class="container">
    <div class="roles">

        <div class="card">
            <h2>User</h2>
            <p>Submit e-waste and track your impact.</p>
            <div class="btn-group">
                <a class="btn primary" href="user_signup.php">Sign Up</a>
                <a class="btn secondary" href="login.php">Login</a>
            </div>
        </div>

        <div class="card">
            <h2>Admin</h2>
            <p>Manage submissions and collections.</p>
            <div class="btn-group">
                <a class="btn secondary" href="login.php">Admin Login</a>
            </div>
        </div>

        <div class="card">
            <h2>Public</h2>
            <p>View submissions and get inspired.</p>
            <div class="btn-group">
                <a class="btn primary" href="public_view.php">Explore</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
