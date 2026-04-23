<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$recruiter_id = $_SESSION['user']['id'];
?>

<link rel="stylesheet" href="style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="top-bar">
    <a href="dashboard.php" class="profile-btn">⬅ Dashboard</a>
</div>

<h2 class="page-title">🔔 Recruiter Notifications</h2>

<div class="jobs-container">

<!-- ========================= -->
<!-- ✅ 1. MATCHING PROFILES -->
<!-- ========================= -->

<h3 style="color:white;">🎯 Matching Job Seekers</h3>

<?php
$query1 = "
SELECT users.name, users.email, users.job_role, users.skills
FROM users
JOIN jobs ON users.job_role = jobs.title
WHERE jobs.recruiter_id = '$recruiter_id'
";

$result1 = $conn->query($query1);

while($row = $result1->fetch_assoc()){
?>

<div class="job-card">
    <h3>👤 <?php echo $row['name']; ?></h3>
    <p>📧 <?php echo $row['email']; ?></p>
    <p>💼 Role: <?php echo $row['job_role']; ?></p>
    <p>🛠 Skills: <?php echo $row['skills']; ?></p>
</div>

<?php } ?>

<!-- ========================= -->
<!-- ✅ 2. NEW APPLICATIONS -->
<!-- ========================= -->

<h3 style="color:white; margin-top:30px;">📄 New Applications</h3>

<?php
$query2 = "
SELECT users.name, jobs.title, applications.status
FROM applications
JOIN users ON applications.user_id = users.id
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.recruiter_id = '$recruiter_id'
ORDER BY applications.id DESC
";

$result2 = $conn->query($query2);

while($row = $result2->fetch_assoc()){
?>

<div class="job-card">
    <h3>👤 <?php echo $row['name']; ?></h3>
    <p>💼 Applied for: <b><?php echo $row['title']; ?></b></p>
    <p>Status: 
        <span style="color:
        <?php 
        if($row['status']=="Accepted") echo "green";
        else if($row['status']=="Rejected") echo "red";
        else echo "orange";
        ?>">
        <?php echo $row['status']; ?>
        </span>
    </p>
</div>

<?php } ?>

</div>