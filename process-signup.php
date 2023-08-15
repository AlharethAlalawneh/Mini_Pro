<?php

if (empty($_POST["f_name"]) || empty($_POST["l_name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (first_name, last_name, email, password, confirm_password, phone, date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Make sure to properly hash and secure your passwords
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt->bind_param("sssssss",
                  $_POST["f_name"],
                  $_POST["l_name"],
                  $_POST["email"],
                  $password_hash,
                  $_POST["password_confirmation"],
                  $_POST["phone"],
                  $_POST["bday"]);

                  if ($stmt->execute()) {
                    // Successful insertion, redirect the user
                    header("Location: signup-success.html");
                    exit;
                } else {
                    // Handle insertion failure
                    die("Execution error: " . $stmt->error . " (Code: " . $stmt->errno . ")");
                }
                

$stmt->close();
$mysqli->close();

?>