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

    /* .applybtn{
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
    } */

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
                <li class="job_details" style="background-color:skyblue;">
                    <a href="job_details.php">Job Details</a>
                </li>
                <li class="job_application">
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
            $cid = $jobID = $jobtitle = $jobdesc = $vacancy = $salary = $cpi = $dept = $course = "";
            $stmt = $conn->query("SELECT companyID FROM company WHERE c_email='$email'");
            if($row=$stmt->fetch()) $cid=$row['companyID'];

            echo '<table class="table">';
            echo "<thead>";
            echo "<tr>";
            echo "<th>JOB ID</th>";
            echo "<th>Job Title</th>";
            echo "<th>Job Description</th>";
            echo "<th>Vacancy</th>";
            echo "<th>Salary</th>";
            echo "<th >CPI Criteria</th>";
            echo "<th >Eligible Departments</th>";
            echo "<th >Eligible Course</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $stmt2 = $conn->query("SELECT * from job WHERE companyID='$cid'");
            while($row = $stmt2->fetch()){
            $jobID = $row['jobID'];
            $jobtitle = $row['job_title'];
            $jobdesc = $row['job_description'];
            $vacancy = $row['vacancy'];
            $salary = $row['salary'];
            $cpi = $row['cpi_criteria'];
            $dept = $course = "";
            $stmt3 = $conn->query("SELECT eligible_dept from eligibledept WHERE jobID = $jobID");
            while($edept = $stmt3->fetch()){
                $dept = $dept . $edept['eligible_dept'] . '<br>';
            }
            $stmt4 = $conn->query("SELECT eligible_course from eligiblecourse WHERE jobID = $jobID");
            while($ecourse = $stmt4->fetch()){
                $course = $course . $ecourse['eligible_course'] . '<br>';
            }

                echo "<tr>";
                echo "<td>" . $jobID . "</td>";
                echo "<td>" . $jobtitle . "</td>";
                echo "<td>" . $jobdesc . "</td>";
                echo "<td>" . $vacancy . "</td>";
                echo "<td>" . $salary . "</td>";
                echo "<td>" . $cpi . "</td>";
                echo "<td>" . $dept . "</td>";
                echo "<td>" . $course . "</td>";
                echo "</tr>";
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