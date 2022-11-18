<?php

session_start();

if(!isset($_SESSION['c_loggedin']) || $_SESSION['c_loggedin'] !==true)
{
    header("location: rlogin.php");
}

require_once "../config.php";
$login_email = $_SESSION['c_email'];
$companyID = $_SESSION['Cid'];

$jobtitle = "";
$jobdesc = "";
$salary = "";
$vacancy = "";
$eligiblecourse; $eligibledept;
$cpicriteria = "";
$examdate = "";
$examduration = "";
$examtype = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $jobtitle = trim($_POST["job_name"]);
    $jobdesc = trim($_POST["job_description"]);
    $salary = trim($_POST["salary"]);
    $vacancy = trim($_POST["vacancy"]);
    $eligiblecourse = ($_POST["eligible_course"]); 
    $eligibledept = ($_POST["eligible_dept"]);
    $cpicriteria = trim($_POST["cpi_criteria"]);
    $examdate = trim($_POST["exam_date"]);
    $examduration = trim($_POST["exam_duration"]);
    $examtype = trim($_POST["exam_type"]);
    
    $sql = "INSERT INTO job (companyID, job_title, job_description, vacancy, salary, cpi_criteria) VALUES ('$companyID', '$jobtitle', '$jobdesc', '$vacancy', '$salary', '$cpicriteria')";
    $stmt = $conn->prepare($sql);
    if ($stmt)
    {
        $stmt->execute();

        $jobID = "";
        $sql1 = "SELECT jobID FROM job WHERE companyID = '$companyID' and job_title='$jobtitle'";
        $stmt1 = $conn->prepare($sql1);
        if($stmt1){
            $stmt1->execute();
            if($row = $stmt1->fetch()){
                $jobID = $row['jobID'];
            }

            $sql2 = "INSERT INTO examination VALUES ('$companyID', '$jobID', '$examdate', '$examduration', '$examtype')";
            $conn->exec($sql2);
            foreach($eligibledept as $dept){
                $sql3 = "INSERT INTO eligibledept (jobID, eligible_dept) VALUES ('$jobID', '$dept')";
                $conn->exec($sql3);
            }
            
            foreach($eligiblecourse as $course){
                $sql3 = "INSERT INTO eligiblecourse (jobID, eligible_course) VALUES ('$jobID', '$course')";
                $conn->exec($sql3);
            }
        }
        $stmt1 = null;
    }
    $stmt = null;
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
    <link rel="stylesheet" href="recruiter.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <span class="open_nav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <nav class="left">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <ul class="left_list">
                <li class="profile">
                    <a href="recruiter.php">Home</a>
                </li>
                <li class="job" style="background-color:skyblue;">
                    <a href="job.php">Fill Job Details</a>
                </li>
                <li class="job_details">
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
            <form class="company_info" action="" method="POST">
                <h2 class="company_heading">Job Details</h2>
                <div class="company_container">
                    <div class="company_nav">
                        <a href="#" >Job Information</a>
                    </div>
                    <hr>
                    <div class="company_info_container">
                        <div class="jobtitle_description">
                            <div class="job_title">
                                <label><div>Job Title</div></label>
                                <input type="text" name="job_name" placeholder="Enter Job Name" required>
                            </div>
                            <div class="job_description">
                                <label><div>Job Description</div></label>
                                <input type="text" name="job_description" placeholder="Enter Job Description">
                            </div>
                        </div>
                        <div class="vacancy_salary">
                            <div class="vacancy">
                                <label><div>Vacancy</div></label>
                                <input type="text" name="vacancy" placeholder="Enter Vacancies" required>
                            </div>
                            <div class="salary">
                                <label><div>Salary</div></label>
                                <input type="text" name="salary" placeholder="Enter Salary" required>
                            </div>
                        </div>
                        <div class="eligibledept_course">
                            <div class="eligible_dept">
                                <label><div>Eligible Departments</div></label>
                                <!-- <input type="text" name="eligible_dept" placeholder="Enter Eligible Departments" required> -->
                                <select name="eligible_dept[]" class="multiselect" required multiple>
                                    <!-- <option value="" disabled selected>Select Eligible Departments</option> -->
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                                    <option value="Physics">Physics</option>
                                    <option value="Chemistry">Chemistry</option>
                                    <option value="Electronics & Electrical Engineering">Electronics & Electrical Engineering</option>
                                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                                    <option value="Civil Engineering">Civil Engineering</option>
                                    <option value="Design">Design</option>
                                    <option value="Chemical Engineering">Chemical Engineering</option>
                                </select>
                            </div>
                            <div class="eligible_course">
                                <label><div>Eligible Courses</div></label>
                                <!-- <input type="text" name="eligible_course" placeholder="Enter Eligible Courses" required> -->
                                <select name="eligible_course[]" class="multiselect" required multiple>
                                    <!-- <option value="" disabled selected>Select Eligible Course</option> -->
                                    <option value="MSc Mathematics & Computing">MSc Mathematics & Computing</option>
                                    <option value="MSc Physics">MSc Physics</option>
                                    <option value="MSc Chemistry">MSc Chemistry</option>
                                    <option value="BTech CSE">BTech CSE</option>
                                    <option value="BTech EEE">BTech EEE</option>
                                    <option value="BTech Mechanical Engineering">BTech Mechanical Engineering</option>
                                    <option value="BTech Civil Engineering">BTech Civil Engineering</option>
                                    <option value="Design (BDes)">Design (BDes)</option>
                                    <option value="BTech Chemical Engineering">BTechChemical Engineering</option>
                                    <option value="MTech CSE">MTech CSE</option>
                                    <option value="MTech EEE">MTech EEE</option>
                                </select>
                            </div>
                        </div>
                        <div class="cpicriteria_">
                            <div class="cpi_criteria">
                                <label><div>CPI Criteria</div></label>
                                <input type="text" name="cpi_criteria" placeholder="Enter CPI Criteria" required>
                            </div>
                        </div>
                    </div>
                    <div class="company_nav">
                        <a href="#" >Examination</a>
                    </div>
                    <hr>
                    <div class="company_info_container">
                        <div class="examdate_duration">
                            <div class="exam_date">
                                <label><div>Exam Date</div></label>
                                <input type="date" name="exam_date" required>
                            </div>
                            <div class="exam_duration">
                                <label><div>Exam Duration</div></label>
                                <input type="text" name="exam_duration" placeholder="Enter Exam Duration" required>
                            </div>
                        </div>
                        <div class="examtype_">
                            <div class="exam_type" style="display:inline;">
                                <label style="font-size:16px;">Exam Type</label><br>
                                <input type="radio" name="exam_type" value="Offline">
                                <label for="Offline">Offline</label>
                                <input type="radio" name="exam_type" value="Online">
                                <label for="Online">Online</label>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div>
                        <button class="btn" type="submit">save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    function openNav() {
    document.querySelector(".left").style.width = "200px";
    }
    function closeNav() {
    document.querySelector(".left").style.width = "0";
    }
    $(document).ready(function(){
    $(".multiselect").select2({
    // maximumSelectionLength: 2
    }); });
    </script>
</body>
</html>