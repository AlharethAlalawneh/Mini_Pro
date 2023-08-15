<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
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
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.32);
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.36);
        }
        button{
            background-color: #B139B7;
            border: none;
        }

        button:hover {
            background-color: black;
        }
      button a {
        color: #ffffff;
      }
    </style>
<body>
    
   
<section class="wrapper">
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
    <h1 style="color: white;">Login</h1>
        <label for="email">email</label>
        <input type="email" name="email" id="email"
               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button style="color: #ffffff;">Log in</button>
        <div class="remember-forgot">
            <label><input type="checkbox">Remember me </label>
            <div class="login-register">
                <p>Don't have an account? <a href="signup.html" class="register-link" style="color: rgb(215, 207, 207);">Sign up</a> </p>
                

            </div>
        </div>
    </form>
</section>
</body>
</html>