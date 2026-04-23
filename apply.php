<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php'; 
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// ✅ FIX: check job_id exists
if(!isset($_GET['job_id'])){
    die("Invalid Job ID");
}
$job_id = $_GET['job_id'];

if(isset($_POST['apply'])){

    $cover = $_POST['cover'];

    // ✅ upload resume safely
    $targetDir = "uploads/";

    // create uploads folder if not exists
    if(!is_dir($targetDir)){
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["resume"]["name"]);
    $targetFile = $targetDir . $fileName;

    if(move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)){

        // ✅ save FULL PATH (important)
        $conn->query("INSERT INTO applications(user_id, job_id, resume, cover_letter)
        VALUES(".$user['id'].", $job_id, '$targetFile', '$cover')");

        echo "<script>alert('✅ Applied Successfully'); window.location='jobs.php';</script>";

    } else {
        echo "<script>alert('❌ File upload failed');</script>";
    }
}
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="container">
<h2>📄 Apply for Job</h2>

<form method="POST" enctype="multipart/form-data">

<label>📝 Cover Letter</label>
<textarea name="cover" style="width:100%;padding:10px;border-radius:8px;"></textarea>

<label>📎 Upload Resume</label>
<input type="file" name="resume" required>

<button name="apply">🚀 Apply</button>

</form>
</div>