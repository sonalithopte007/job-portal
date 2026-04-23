<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

/* ✅ HANDLE ACCEPT / REJECT */
if(isset($_POST['accept'])){
    $id = $_POST['app_id'];
    $conn->query("UPDATE applications SET status='Accepted' WHERE id='$id'");
}

if(isset($_POST['reject'])){
    $id = $_POST['app_id'];
    $conn->query("UPDATE applications SET status='Rejected' WHERE id='$id'");
}
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<!-- Top Bar -->
<div class="top-bar">
    <a href="dashboard.php" class="profile-btn">⬅ Dashboard</a>
</div>

<h2 class="page-title">📄 Applications</h2>

<div class="jobs-container">

<?php
/* ✅ IMPORTANT: ADD applications.id and status */
$query = "
SELECT applications.id, users.name, users.email, jobs.title, 
       applications.resume, applications.cover_letter, applications.status
FROM applications
JOIN users ON applications.user_id = users.id
JOIN jobs ON applications.job_id = jobs.id
";

$result = $conn->query($query);

while($row = $result->fetch_assoc()){
?>

    <div class="job-card">

        <h3>👤 <?php echo $row['name']; ?></h3>

        <p>📧 <?php echo $row['email']; ?></p>

        <p>💼 Applied for: <strong><?php echo $row['title']; ?></strong></p>

        <!-- ✅ STATUS DISPLAY -->
        <p>
            Status: 
            <b style="color:
            <?php 
                if($row['status']=="Accepted") echo "green";
                else if($row['status']=="Rejected") echo "red";
                else echo "orange";
            ?>">
            <?php echo $row['status'] ?? 'Pending'; ?>
            </b>
        </p>

        <?php if(!empty($row['cover_letter'])){ ?>
            <p>📝 "<?php echo $row['cover_letter']; ?>"</p>
        <?php } ?>

        <?php if(!empty($row['resume'])){ ?>
            <a href="<?php echo $row['resume']; ?>" target="_blank" class="resume-btn">
                📄 View Resume
            </a>
        <?php } ?>

        <!-- ✅ ACCEPT / REJECT BUTTONS -->
        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">

            <button name="accept" class="accept-btn">✅ Accept</button>
            <button name="reject" class="reject-btn">❌ Reject</button>
        </form>

    </div>

<?php } ?>

</div>