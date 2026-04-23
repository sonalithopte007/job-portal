<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// popup
if(isset($_SESSION['success'])){
    echo "<script>alert('".$_SESSION['success']."');</script>";
    unset($_SESSION['success']);
}

// login check
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// ✅ THIS PART (UPDATED)
$user_id = $_SESSION['user']['id'];

$result = $conn->query("SELECT * FROM users WHERE id='$user_id'");
$user = $result->fetch_assoc();

$_SESSION['user'] = $user;
?>
<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<!-- ✅ KEEP SAME PROFILE BUTTON -->
<div class="top-bar">

    <!-- 👤 User Info -->
    <div class="user-info">
        <img src="user.png" class="avatar">
        <span class="username"><?php echo $user['name']; ?></span>
    </div>

    <?php if($user['role']=="recruiter"){ ?>
        <a href="recruiter_notifications.php" class="notify-btn">🔔</a>
    <?php } else { ?>
        <a href="notifications.php" class="notify-btn">🔔</a>
    <?php } ?>

    <a href="profile.php" class="profile-btn">Profile</a>

</div>
<div class="container dashboard">
<h2>👋 Welcome <?php echo $user['name']; ?></h2>

<div class="card-grid">

<?php if($user['role']=="recruiter"){ ?>

    <!-- RECRUITER DASHBOARD -->
    <div class="card-box">
        <a href="post_job.php">➕ Post Job</a>
    </div>

    <div class="card-box">
        <a href="view_applications.php">📄 View Applications</a>
    </div>

<?php } else { ?>

    <!-- JOB SEEKER DASHBOARD -->

    <?php
    $user_id = $user['id'];

    // Fetch profile data
    $profile = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();

    $job_role = $profile['job_role'];
    $skills = $profile['skills'];
    ?>

</div>

<!-- 🎯 RECOMMENDED JOBS -->
<h2 style="margin-top:30px;">🎯 Recommended Jobs</h2>
<div class="jobs-container">

<?php
$result1 = $conn->query("
    SELECT * FROM jobs 
    WHERE title LIKE '%$job_role%' 
    OR skills LIKE '%$skills%'
");

while($row = $result1->fetch_assoc()){
?>

    <div class="job-card">
        <h3><?php echo $row['title']; ?></h3>
        <p>🏢 <?php echo $row['company']; ?></p>
        <p>💻 <?php echo $row['skills']; ?></p>

        <a href="apply.php?job_id=<?php echo $row['id']; ?>" class="apply-btn">
            🚀 Apply Now
        </a>
    </div>

<?php } ?>

</div>

<!-- 📌 OTHER JOBS -->
<h2 style="margin-top:30px;">📌 Other Jobs</h2>
<div class="jobs-container">

<?php
$result2 = $conn->query("
    SELECT * FROM jobs 
    WHERE title NOT LIKE '%$job_role%'
");

while($row = $result2->fetch_assoc()){
?>

    <div class="job-card">
        <h3><?php echo $row['title']; ?></h3>
        <p>🏢 <?php echo $row['company']; ?></p>
        <p>💻 <?php echo $row['skills']; ?></p>

        <a href="apply.php?job_id=<?php echo $row['id']; ?>" class="apply-btn">
            🚀 Apply Now
        </a>
    </div>

<?php } ?>

</div>

<?php } ?>

</div>