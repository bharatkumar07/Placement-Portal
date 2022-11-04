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
                    <a href="job.php">Job Details</a>
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
                                <input type="text" name="job_descreption" placeholder="Enter Job Description">
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
                                <input type="text" name="eligible_dept" placeholder="Enter Eligible Departments" required>
                            </div>
                            <div class="eligible_course">
                                <label><div>Eligible Courses</div></label>
                                <input type="text" name="eligible_course" placeholder="Enter Eligible Courses" required>
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