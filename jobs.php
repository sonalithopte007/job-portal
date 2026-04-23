<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

 include 'db.php';
 session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Jobs</title>
    <link rel="stylesheet" href="/job-portal/style.css">
</head>
<body>
<div class="navbar">
    💼 Job Matrix
</div>

<h2 class="page-title">💼 Available Jobs</h2>

<div class="jobs-container">

<?php
$result = $conn->query("SELECT * FROM jobs");

while($row = $result->fetch_assoc()) {
?>

    <div class="job-card">
        <h3><?php echo $row['title']; ?></h3>

        <p><strong>🏢 Company:</strong> <?php echo $row['company']; ?></p>
        <p><strong>💻 Skills Required:</strong> <?php echo $row['skills']; ?></p>

        <a href="apply.php?job_id=<?php echo $row['id']; ?>" class="apply-btn">
            🚀 Apply Now
        </a>
    </div>

<?php } ?>

</div>

</body>
</html>