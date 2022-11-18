<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}

require_once "../config.php";

//to get no_application from student table
$login_email = $_SESSION['email'];
$no_application = $rollno = $course = $deptartment = $fname = $lname = "";
$hide="";
$sql = "SELECT no_application,fname,lname,rollno,dept,course FROM student WHERE s_iitgmail = '$login_email'";
$result = $conn->prepare($sql);
$result->execute();
    if($row = $result->fetch()){
    $no_application = $row['no_application'];
    $rollno = $row['rollno'];
    $course = $row['course'];
    $deptartment = $row['dept'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $hide = "style='display: none'";
    }

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
                <li class="job_application">
                    <a href="jobapplication.php">Job Apllication</a> 
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
                <h1 <?php echo $hide ?> >Go For Registration to Start your portal</h1>
                <?php 
                if($hide) {echo "<div class='no_application'>Number of Application: $no_application / 50</div>" .
                '
                <ul class="home_info_list">
                <li>
                    Name : ' . $fname . ' ' . $lname . '
                </li>
                <li>
                    Roll Number : ' . $rollno . '
                </li>
                <li>
                    IITG Mail : ' . $login_email . '
                </li>
                <li>
                    Department : ' . $deptartment . '
                </li>
                <li>
                    Course : ' . $course . '
                </li>
                </ul>  ';

                if($conn->query("SELECT rollno,jobID FROM offered WHERE rollno='$rollno'")->rowCount()>0){
                    $cname = $jobtitle = $jobID = $cID = "";
                    if($job = $conn->query("SELECT jobID FROM offered WHERE rollno='$rollno'")->fetch()){
                        $jobID = $job['jobID'];
                    }
                    if($job = $conn->query("SELECT job_title, companyID FROM job WHERE jobID = '$jobID'")->fetch()){
                        $jobtitle = $job['job_title'];
                        $cID = $job['companyID'];
                        if($c = $conn->query("SELECT c_name FROM company WHERE companyID='$cID'")->fetch()){
                            $cname = $c['c_name'];
                        }
                    }
                    $hide = true; $rejected = false;
                    if(isset($_REQUEST['accept'])){
                        $jobid=$_REQUEST['applyId'];
                        $rollno=$_REQUEST['applyRoll'];
                        // $sql3="INSERT INTO apply_for (jobID,rollno) VALUES ('$jobid','$rollno')";
                        // $stmt= $conn->query($sql3);
                        // $stmt=null;
                        $hide = false;
                        }
                        if(isset($_REQUEST['reject'])){
                        $jobid=$_REQUEST['withdrawId'];
                        $rollno=$_REQUEST['withdrawRoll'];
                        $sql4="DELETE FROM offered WHERE jobID='$jobid' AND rollno='$rollno'";
                        $stmt= $conn->query($sql4);
                        $stmt=null;
                        $hide = false;
                        $rejected = true;
                        }

                    if(!$rejected) echo "<h2 style='text-align:center; color:black; margin-top:10%;'>Congratulations you got the offer from ". $cname . " Company and Job Profile is "
                    . $jobtitle . "
                    </h2>";
                    if($hide) {echo '<div style="display:flex; justify-content: space-evenly; ">
                    <form action="" method="POST"><input type="hidden" name="applyId" value=' . $jobID. '>
                    <input type="hidden" name="applyRoll" value=' . $rollno . '>
                    <input type="submit" class="btn" name="accept" value="Accept"></form> 

                    <form action="" method="POST"><input type="hidden" name="withdrawId" value=' . $jobID . '>
                    <input type="hidden" name="withdrawRoll" value=' . $rollno . '>
                    <input style="background-color:red;" type="submit" class="btn" name="reject" value="Reject"></form>
                    </div>';
                    }
                }
                }
                ?>
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