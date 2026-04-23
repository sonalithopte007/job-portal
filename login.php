<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if($res && $res->num_rows > 0){
        $_SESSION['user'] = $res->fetch_assoc();
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="container">
<h2>🔐 Login</h2>

<form method="POST">
<label>📧 Email</label>
<input type="email" name="email" required>

<label>🔒 Password</label>
<input type="password" name="password" required>

<button name="login">Login</button>

<p style="text-align:center; margin-top:15px;">
    Don't have an account? 
    <a href="register.php" class="login-link">Register</a>
</p>

</form>
</div>