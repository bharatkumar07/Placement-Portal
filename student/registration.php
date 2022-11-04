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
    while($row = $result->fetch()){
        $no_application = $row['no_application'];
    }



$firstname = $lastname = $iitgmail = $email = $rollno = $mobile = $gender = $dob = $department = $course = $cpi = "";
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $firstname = trim($_POST["first_name"]);
    $lastname = trim($_POST["last_name"]);
    $iitgmail = trim($_POST["iitg_mail"]);
    $email = trim($_POST["email"]);
    $rollno = trim($_POST["roll_no"]);
    $mobile = trim($_POST["mobile"]);
    $gender = trim($_POST["gender"]);
    $dob = trim($_POST["dob"]);
    $department = trim($_POST["department"]);
    $course = trim($_POST["course"]);
    $cpi = trim($_POST["cpi"]);
    $sql = "INSERT INTO student (fname, lname, s_iitgmail, s_email, rollno, mobile, gender, dob, dept, course, cpi) VALUES ('$firstname', '$lastname', '$iitgmail', '$email', '$rollno', '$mobile', '$gender', '$dob', '$department', '$course', '$cpi' )";
    $stmt = $conn->prepare($sql);
    if ($stmt)
    {
        $stmt->execute();
    }
    // mysqli_stmt_close($stmt);
$conn = null;
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
                <li class="profile">
                    <a href="student.php">Profile</a>
                </li>
                <li class="registration">
                    <a href="registration.php" style="background-color:skyblue;">Registration</a>
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
            <form class="profile_info" action="" method="POST">
                <h2 class="profile_heading">Profile</h2>
                <div class="profile_container">
                    <div class="profile_nav">
                        <a href="#" class="basic_info">Basic Information</a>
                        <?php echo "Number of Application: ".$no_application. " / 50" ?>
                    </div>
                    <hr>
                    <div class="basic_info_container profile_info_container">
                        <div class="student_name">
                            <div class="first_name">
                                <label><div>First Name</div></label>
                                <input type="text" name="first_name" placeholder="Enter First Name" required>
                            </div>
                            <div class="last_name">
                                <label><div>Last Name</div></label>
                                <input type="text" name="last_name" placeholder="Enter Last Name">
                            </div>
                        </div>
                        <div class="student_email">
                            <div class="iitg_mail">
                                <label><div>IITG Mail</div></label>
                                <input type="email" name="iitg_mail" placeholder="Enter your IITG mail" required>
                            </div>
                            <div class="personal_email">
                                <label><div>Personal Email</div></label>
                                <input type="email" name="email" placeholder="Enter your personal email" required>
                            </div>
                        </div>
                        <div class="rollno_mobile">
                            <div class="roll_no">
                                <label><div>Roll No</div></label>
                                <input type="number" name="roll_no" placeholder="Enter your Roll No" required required>
                            </div>
                            <div class="mobile">
                                <label><div>Mobile Number</div></label>
                                <input type="number" name="mobile" placeholder="Enter your Mobile No" required required>
                            </div>
                        </div>
                        <div class="gender_dob">
                            <div class="gender" style="display:inline;">
                                <label style="font-size:16px;">Gender</label><br>
                                <input type="radio" name="gender" value="male">
                                <label for="male">Male</label>
                                <input type="radio" name="gender" value="female">
                                <label for="female">Female</label>
                                <input type="radio" name="gender" value="other">
                                <label for="other">Other</label>
                            </div>
                            <div class="dob">
                                <label><div>Date of Birth</div></label>
                                <input type="date" name="dob" placeholder="Enter your dob" required>
                            </div>
                        </div>
                    </div>
                    <div class="profile_nav">
                        <a href="#" class="academics">Academics</a>
                    </div>
                    <hr>
                    <div class="academics_container profile_info_container">
                        <div class="dept_course">
                            <div class="department">
                                <label><div>Department</div></label>
                                <input type="text" name="department" placeholder="Enter your Department" required>
                            </div>
                            <div class="course">
                                <label><div>Course</div></label>
                                <input type="text" name="course" placeholder="Enter Your Course Name" required>
                            </div>
                        </div>
                        <div class="cpi_">
                            <div class="cpi">
                                <label><div>CPI</div></label>
                                <input type="text" name="cpi" placeholder="Enter your cpi" required>
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