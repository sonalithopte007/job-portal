<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "db.php";

$user_id = $_SESSION['user']['id'];

$result = $conn->query("
SELECT jobs.title, applications.status 
FROM applications 
JOIN jobs ON jobs.id = applications.job_id 
WHERE applications.user_id = '$user_id'
");
?>

<link rel="stylesheet" href="style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="container">
<h2>🔔 Notifications</h2>

<?php while($row = $result->fetch_assoc()){ ?>

<div class="card">
    <p><b>Job:</b> <?= $row['title'] ?></p>
    <p><b>Status:</b> 
        <span style="color:
        <?= $row['status']=='Accepted'?'green':($row['status']=='Rejected'?'red':'orange') ?>">
        <?= $row['status'] ?>
        </span>
    </p>
</div>

<?php } ?>

<a href="dashboard.php" class="back-btn">⬅ Back</a>
</div>