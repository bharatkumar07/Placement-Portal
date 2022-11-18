<?php

session_start();

if(!isset($_SESSION['c_loggedin']) || $_SESSION['c_loggedin'] !==true)
{
    header("location: rlogin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement-Portal</title>
    <link rel="stylesheet" href="recruiter.css">
    <style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    background-color: white;
    width: 100%;
    }

    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    } 

    .applybtn{
    font-size: 1.02rem;
    background-color: #0b63c0;
    padding: 6px 15px;
    color: white;
    margin: 20px;
    border: 0;
    width: 100px;
    border-radius: 4px; 
    }
    .applybtn:hover{
    cursor: pointer;
    text-decoration: underline; 
    }

    /* tr:nth-child(even) {
    background-color: #dddddd;
    } */
    </style> 
</head>
<body>
    <div class="container">
        <span class="open_nav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <nav class="left">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <ul class="left_list">
                <li class="profile" >
                    <a href="recruiter.php">Home</a>
                </li>
                <li class="job">
                    <a href="job.php">Fill Job Details</a>
                </li>
                <li class="job_details">
                    <a href="job_details.php">Job Details</a>
                </li>
                <li class="job_application" style="background-color:skyblue;">
                    <a href="job_applied.php">Job Apllication</a> 
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
                    <a href="rlogout.php"> Click here to logout</a>
                </div>
            </div>
            <?php
            require_once "../config.php";
            $email = $_SESSION['c_email'];
            $ID = 0;
            $hide = "";
            $cid = $jobID = "";

            if(isset($_REQUEST['offer'])){
                $jobid=$_REQUEST['applyId'];
                $roll=$_REQUEST['applyRoll'];
                $sql3="INSERT INTO offered (jobID,rollno) VALUES ('$jobid','$roll')";
                $stmt4= $conn->query($sql3);
                $stmt4=null;
            }

            $stmt = $conn->query("SELECT companyID FROM company WHERE c_email='$email'");
            if($row=$stmt->fetch()) $cid=$row['companyID'];

            echo '<table class="table">';
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Student Roll no.</th>";
            echo "<th>Student Name</th>";
            echo "<th>Job Profile</th>";
            echo "<th>Student Mail</th>";
            echo "<th >Contact No.</th>";
            echo "<th>Give Offer</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $stmt2 = $conn->query("SELECT jobID,job_title from job WHERE companyID='$cid'");
            while($row = $stmt2->fetch()){
            $jobID = $row['jobID'];
            $jobtitle = $row['job_title'];
            $sql= "SELECT * FROM apply_for WHERE jobID=$jobID";
            $result= $conn->query($sql);

            
            if($result->rowCount() > 0){
            
            while($row=$result->fetch(PDO::FETCH_ASSOC)){
                $rollno= $fname = $lname = $student_mail = $mobile = "";
                $rollno = $row['rollno'];
                $sql2 = "SELECT fname, lname, s_iitgmail, mobile FROM student WHERE rollno = '$rollno'";
                $stmt3= $conn->query($sql2);
                    if($dataStudent=$stmt3->fetch()){
                        $fname = $dataStudent['fname'];
                        $lname = $dataStudent['lname'];
                        $student_mail = $dataStudent['s_iitgmail'];
                        $mobile = $dataStudent['mobile'];
                    }
                    $ID++;

                echo "<tr>";
                echo "<td>" . $ID . "</td>";
                echo "<td>" . $rollno . "</td>";
                echo "<td>" . $fname . " " . $lname . "</td>";
                echo "<td>" . $jobtitle . "</td>";
                echo "<td>" . $student_mail . "</td>";
                echo "<td>" . $mobile . "</td>";

                if($conn->query("SELECT * FROM offered WHERE jobID='$jobID' and rollno='$rollno'")->rowCount()>0){
                    $hide = "style= 'display:none'";
                }
                else{
                    $hide = "";
                }
                echo '<td '. $hide . '><form action="" method="POST"><input type="hidden" name="applyId" value=' . $jobID . '>
                <input type="hidden" name="applyRoll" value=' . $rollno . '>
                <input type="submit" class="applybtn" name="offer" value="Give Offer"></form></td>';
                echo "</tr>";
        }
        }
        }
        echo "</tbody>";
        echo "</table>";
            ?>
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