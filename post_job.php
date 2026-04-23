<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// ✅ Handle form submission FIRST (before HTML)
if(isset($_POST['post'])){

    $title = $_POST['title'];
    $skills = $_POST['skills'];
    $company = $_POST['company'];
    $recruiter_id = $_SESSION['user']['id'];

    $query = "INSERT INTO jobs(title, skills, company, recruiter_id)
              VALUES('$title','$skills','$company','$recruiter_id')";

    if($conn->query($query)){

        // ✅ store message in session
        $_SESSION['success'] = "Job Posted Successfully!";

        // ✅ redirect to dashboard
        header("Location: dashboard.php");
        exit();

    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="container">
<h2>➕ Post Job</h2>

<form method="POST">

<label>Job Title</label>
<input type="text" name="title" required>

<label>Required Skills</label>
<input type="text" name="skills" placeholder="Java, PHP, AWS">

<label>Company Name</label>
<input type="text" name="company" required>

<button name="post">🚀 Post Job</button>

</form>

<a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

</div>