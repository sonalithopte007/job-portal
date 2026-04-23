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
$userSkills = strtolower($user['skills'] ?? '');
?>

<link rel="stylesheet" href="/job-portal/style.css">
<div class="navbar">
    💼 Job Matrix
</div>
<div class="container">
<h2>🤖 Recommended Jobs For You</h2>

<?php
if(empty($userSkills)){
    echo "<p>Please update your profile skills first.</p>";
} else {

$res = $conn->query("SELECT * FROM jobs");

while($row = $res->fetch_assoc()){
$jobSkills = strtolower($row['skills']);

similar_text($userSkills, $jobSkills, $percent);

// show only good matches
if($percent > 40){
echo "<div class='card'>";
echo "<h3>".$row['title']."</h3>";
echo "<p>🏢 ".$row['company']."</p>";
echo "<p>🛠 ".$row['skills']."</p>";
echo "<p>🎯 Match: ".round($percent)."%</p>";
echo "<a href='apply.php?id=".$row['id']."'>Apply</a>";
echo "</div>";
}
}
}
?>
</div>