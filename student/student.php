<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}

require_once "../config.php";

//to get no_application from student table
$login_email = $_SESSION['email'];
$no_application = "";
$sql = "SELECT no_application FROM student WHERE s_email = '$login_email'";
$result = $conn->prepare($sql);
$result->execute();
    if($row = $result->fetch()){
    $no_application = $row['no_application'];
    }

$conn = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement-Portal</title>
    <link rel="stylesheet" href="student.css">
</head>
<body>
    <div class="container">
        <span class="open_nav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <nav class="left">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <ul class="left_list">
                <li class="profile" style="background-color:skyblue;">
                    <a href="student.php">Home</a>
                </li>
                <li class="registration">
                    <a href="registration.php">Registration</a>
                </li>
                <li class="preference_list">
                    <a href="#">Preference List</a> 
                </li>
                <li class="job_application">
                    <a href="#">Job Apllication</a> 
                </li>
                <li class="user_guide">
                    <a href="#">User Guide</a>
                </li>
            </ul>
        </nav>
        <div class="right">
            <div class="nav_bar">
                <div class="left_nav">
                    <img class="IITG_logo" src="https://swc.iitg.ac.in/placement-portal/static/images/logo.png" alt="IITG Logo">
                    <span>Placement Portal</span>
                </div>
                <div class="right_nav">
                    <a href="logout.php"> Click here to logout</a>
                </div>
            </div>
            <div class="home_info">
                <?php echo "<div class='no_application'>Number of Application: $no_application / 50</div>" ?>
            </div>
        </div>
    </div>

    <script>
    function openNav() {
    document.querySelector(".left").style.width = "200px";
    }

    function closeNav() {
    document.querySelector(".left").style.width = "0";
    }
    </script>
</body>
</html>