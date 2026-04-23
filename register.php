
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Run only when form is submitted
if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users(name,email,password,role) 
            VALUES('$name','$email','$password','$role')";

    if($conn->query($sql) === TRUE){
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Job Matrix</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f6f8;
        }

        /* Navbar */
        .navbar {
            background-color: #0a66c2;
            color: white;
            padding: 15px 30px;
            font-size: 22px;
            font-weight: bold;
        }

        /* Center container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #0a66c2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004182;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        a {
            color: #0a66c2;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="navbar">💼 Job Matrix</div>

<div class="container">
    <div class="form-box">
        <h2>Create Account</h2>

        <form method="POST">
            <input type="text" name="name" placeholder="👤 Full Name" required>
            <input type="email" name="email" placeholder="📧 Email" required>
            <input type="password" name="password" placeholder="🔒 Password" required>

            <select name="role">
                <option value="jobseeker">👨‍💼 Job Seeker</option>
                <option value="recruiter">🏢 Recruiter</option>
            </select>

            <button type="submit" name="submit">🚀 Register</button>

            <div class="login-link">
                Already have an account?
                <a href="login.php">Login</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>