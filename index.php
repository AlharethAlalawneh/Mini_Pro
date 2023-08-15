<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: right;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .wrapper {
            padding: 8%;
            background-color: rgba(255, 255, 255, 0.32);
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.36);
        }

        .wrapper h1 {
            color: white;
            margin-bottom: 20px;
        }

        button{
            background-color: #B139B7;
            border: none;
        }

        button:hover {
            background-color: black;
        }
      
    </style>
</head>
<body>
    <section class="wrapper">
    <h1 style="color: white;">Welcome Home</h1>
    
    
    <?php if (isset($user)): ?>
        
        <p>Hello <?= htmlspecialchars($user["first_name"]) ?></p>
        <p>email <?= htmlspecialchars($user["email"]) ?></p>
        <p>phone <?= htmlspecialchars($user["phone"]) ?></p>
        <p>date <?= htmlspecialchars($user["date"]) ?></p>
        <button><a href="logout.php" style="color: white;">Log out</a></button>
        
    <?php else: ?>
        
        <button><a href="login.php" style="color: white;">Log in</a></button> or 
        <button><a href="signup.html" style="color: white;">sign up</a></button>
        
    <?php endif; ?>
    </section>
</body>
</html>
    
    
    
    