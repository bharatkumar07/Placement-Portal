<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
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
                <li class="profile">
                    <a href="student.php">Home</a>
                </li>
                <li class="registration">
                    <a href="registration.php">Registration</a>
                </li>
                <!-- <li class="preference_list">
                    <a href="#">Preference List</a> 
                </li> -->
                <li class="job_application">
                    <a href="jobapplication.php" style="background-color:skyblue;">Job Apllication</a> 
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
            <div class="Container">
            <?php
            require_once "../config.php";
            $email = $_SESSION['email'];
            $ID = 0;
            $hide = "";

            $no_application = "";
            $sql = "SELECT no_application FROM student WHERE s_iitgmail = '$email'";
            $result = $conn->prepare($sql);
            $result->execute();
                if($row = $result->fetch()){
                $no_application = $row['no_application'];
                }

            if(isset($_REQUEST['apply'])){
            $jobid=$_REQUEST['applyId'];
            $rollno=$_REQUEST['applyRoll'];
            $sql3="INSERT INTO apply_for (jobID,rollno) VALUES ('$jobid','$rollno')";
            $stmt= $conn->query($sql3);
            $stmt=null;
            $no_application=$no_application+1;
            $conn->query("UPDATE student SET no_application='$no_application' WHERE s_iitgmail='$email'");
            }
            if(isset($_REQUEST['withdraw'])){
            $jobid=$_REQUEST['withdrawId'];
            $rollno=$_REQUEST['withdrawRoll'];
            $sql4="DELETE FROM apply_for WHERE jobID='$jobid' AND rollno='$rollno'";
            $stmt= $conn->query($sql4);
            $stmt=null;
            $no_application=$no_application-1;
            $conn->query("UPDATE student SET no_application='$no_application' WHERE s_iitgmail='$email'");
            }

            echo "<div style='text-align:right; font-size:1.25rem; color:black; padding:2px 5px;'> Number of Applications: $no_application / 50 </div>";
            $sql= "SELECT * FROM job";
            $result= $conn->query($sql);
            if($result->rowCount() > 0){
                echo '<table class="table">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Company Name</th>";
                echo "<th>Job Profile</th>";
                echo "<th>Job Description</th>";
                echo "<th>Job Details</th>";
                echo "<th>Exam Details</th>";
                echo "<th >Apply</th>";
                //echo "<th>Withdraw</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row=$result->fetch(PDO::FETCH_ASSOC)){

                    $cpicriteria = $row['cpi_criteria'];
                    $jobid=$row["jobID"];
                    $eligibledept = "";
                    $eligiblecourse = "";
                    $roll = $student_cpi = $student_dept = $student_course = "";
                    $sql2 = "SELECT rollno, cpi, course, dept FROM student WHERE s_iitgmail = '$email'";
                    $st= $conn->query($sql2);
                        if($dataStudent=$st->fetch()){
                            $roll=$dataStudent['rollno'];
                            $student_cpi = $dataStudent['cpi'];
                            $student_course = $dataStudent['course'];
                            $student_dept = $dataStudent['dept'];
                        }
                    
                    $sql5 = "SELECT eligible_dept FROM eligibledept WHERE jobID = '$jobid' and eligible_dept='$student_dept'";
                    $stmt2 = $conn->query($sql5);
                    $sql6 = "SELECT eligible_course FROM eligiblecourse WHERE jobID = '$jobid' and eligible_course='$student_course'";
                    $stmt3 = $conn->query($sql6);
                    
                if($stmt2->rowCount()==1 && $stmt3->rowCount()==1){
                    if($cpicriteria<=$student_cpi){
                        $ID++;

                    echo "<tr>";
                    echo "<td>" . $ID . "</td>";
                    $cid=$row["companyID"];
                    $sql1 = "SELECT c_name FROM company WHERE companyID = '$cid'";
                    $r= $conn->query($sql1);
                    if($data=$r->fetch()){
                        $cname=$data['c_name'];
                    }
                
                    echo "<td>" . $cname . "</td>";
                    echo "<td>" . $row["job_title"] . "</td>";
                    echo "<td>" . $row["job_description"] . "</td>";
                    echo "<td>" . 'Vacancies: '. $row["vacancy"] . '<br>Salary: ' . $row['salary'] . "</td>";

                    //To Show Exam Details
                    $stmt4 = $conn->query("SELECT exam_date, duration, exam_type FROM examination WHERE jobID='$jobid'");
                    echo "<td style='font-size: 0.9rem;'>";
                    if($exam=$stmt4->fetch()){
                        echo 'Exam Date: '.$exam['exam_date'] . '<br>'. 'Duration: ' . $exam['duration'] . '<br>'. 'Exam Type: ' . $exam['exam_type'];
                    }
                    echo "</td>";

                    $hideapply=$conn->query("SELECT jobID, rollno FROM apply_for WHERE jobID='$jobid' and rollno='$roll'");
                    if($hideapply->rowCount()>0) $hide="style='display: none'";
                    else $hide="";

                    echo '<td '. $hide . '><form action="" method="POST"><input type="hidden" name="applyId" value=' . $row["jobID"] . '>
                                    <input type="hidden" name="applyRoll" value=' . $roll . '>
                        <input type="submit" class="applybtn" name="apply" value="Apply"></form></td>';
                     if($hide) echo '<td><form action="" method="POST"><input type="hidden" name="withdrawId" value=' . $row["jobID"] . '>
                            <input type="hidden" name="withdrawRoll" value=' . $roll . '>
                        <input type="submit" class="applybtn" name="withdraw" value="Withdraw"></form></td>';
                    echo "</tr>";
                }
                }}
                
                echo "</tbody>";
                echo "</table>";

            }
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