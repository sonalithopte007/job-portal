<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

// ✅ Check login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

// ✅ Get user from session
$user = $_SESSION['user'];
$user_id = $user['id'];

// ✅ Fetch latest data
$result = $conn->query("SELECT * FROM users WHERE id='$user_id'");
$user = $result->fetch_assoc();

$success = "";

// ✅ Save profile
if(isset($_POST['save'])){

    $name = $_POST['name'];

    // COMMON
    $resume = $user['resume'] ?? "";

    // Upload resume
    if(!empty($_FILES['resume']['name'])){
        if(!is_dir("uploads")){
            mkdir("uploads");
        }

        $resume = "uploads/" . time() . "_" . $_FILES['resume']['name'];
        move_uploaded_file($_FILES['resume']['tmp_name'], $resume);
    }

    // 👩‍💻 JOB SEEKER UPDATE
    if($user['role'] == "jobseeker"){

        $age = $_POST['age'];
        $qualification = $_POST['qualification'];
        $job_role = $_POST['job_role'];
        $skills = $_POST['skills'];

        $conn->query("UPDATE users SET 
            name='$name',
            age='$age',
            qualification='$qualification',
            job_role='$job_role',
            skills='$skills',
            resume='$resume'
            WHERE id='$user_id'
        ");

    } 
    // 👨‍💼 RECRUITER UPDATE
    else {

        $company_name = $_POST['company_name'];
        $company_type = $_POST['company_type'];
        $company_website = $_POST['company_website'];

        $conn->query("UPDATE users SET 
            name='$name',
            company_name='$company_name',
            company_type='$company_type',
            company_website='$company_website'
            WHERE id='$user_id'
        ");
    }

    $success = "Profile Updated Successfully!";
}
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<!-- TOP BAR -->
<div class="top-bar">
    <a href="dashboard.php" class="profile-btn">⬅ Dashboard</a>
</div>

<div class="container">

<h2>👤 My Profile</h2>

<!-- SUCCESS MESSAGE -->
<?php if($success){ ?>
    <div class="success-msg">
        ✅ <?php echo $success; ?>
    </div>

    <script>
        alert("Profile Updated Successfully!");
    </script>
<?php } ?>

<?php
// refresh data
$result = $conn->query("SELECT * FROM users WHERE id='$user_id'");
$user = $result->fetch_assoc();

// update session
$_SESSION['user'] = $user;
?>
<form method="POST" enctype="multipart/form-data">

<label>👤 Name</label>
<input type="text" name="name" value="<?= $user['name'] ?? '' ?>" required>

<?php if($user['role']=="jobseeker"){ ?>

    <!-- 👩‍💻 JOB SEEKER -->

    <label>🎂 Age</label>
    <input type="number" name="age" value="<?= $user['age'] ?? '' ?>">

    <label>🎓 Qualification</label>
    <input type="text" name="qualification" value="<?= $user['qualification'] ?? '' ?>">

    <label>💼 Desired Job Role</label>
    <input type="text" name="job_role" value="<?= $user['job_role'] ?? '' ?>">

    <label>🛠 Skills</label>
    <input type="text" name="skills" value="<?= $user['skills'] ?? '' ?>">

    <label>📎 Upload Resume</label>
    <input type="file" name="resume">

    <?php if(!empty($user['resume'])){ ?>
        <p class="resume-text">
            📄 <a href="<?= $user['resume'] ?>" target="_blank">View Resume</a>
        </p>
    <?php } ?>

<?php } else { ?>

    <!-- 👨‍💼 RECRUITER -->

    <label>🏢 Company Name</label>
    <input type="text" name="company_name" value="<?= $user['company_name'] ?? '' ?>" required>

    <label>🏭 Company Type</label>
    <input type="text" name="company_type" value="<?= $user['company_type'] ?? '' ?>">

    <label>🌐 Company Website</label>
    <input type="text" name="company_website" value="<?= $user['company_website'] ?? '' ?>">

<?php } ?>

<button name="save">💾 Save Profile</button>
<a href="logout.php" class="logout-btn">🚪 Logout</a>
</form>

</div>