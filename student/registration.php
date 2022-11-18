<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}

require_once "../config.php";

$login_email = $_SESSION['email'];
$no_application = "";
$hide = "";

$firstname = "Enter First Name";
$lastname = "Enter Last Name";
$iitgmail = $login_email;
$email = "Enter your personal email";
$rollno = "Enter your Roll No";
$mobile = "Enter your Mobile No";
$gender = "";
$dob = "Enter Date of Birth";
$department = "Choose your Department";
$course =  "Choose Your Course Name";
$cpi = "Enter your cpi";
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
    $stmt = null;
}

$sql = "SELECT no_application, fname, lname, s_iitgmail, s_email, rollno, mobile, gender, dob, dept, course, cpi FROM student WHERE s_iitgmail = '$login_email'";
$result = $conn->prepare($sql);
$result->execute();
    if($row = $result->fetch()){
        $no_application = $row['no_application'];
        $hide = "style='display: none'";

        $firstname = $row["fname"];
        $lastname = $row["lname"];
        $iitgmail = $row["s_iitgmail"];
        $email = $row["s_email"];
        $rollno = $row["rollno"];
        $mobile = $row["mobile"];
        $gender = $row["gender"];
        $dob = $row["dob"];
        $department = $row["dept"];
        $course = $row["course"];
        $cpi = $row["cpi"];
    }
$result = null;
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
                <li class="profile">
                    <a href="student.php">Home</a>
                </li>
                <li class="registration">
                    <a href="registration.php" style="background-color:skyblue;">Registration</a>
                </li>
                <!-- <li class="preference_list">
                    <a href="#">Preference List</a> 
                </li> -->
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
                                <input type="text" name="first_name" placeholder='<?php echo $firstname ?>' required>
                            </div>
                            <div class="last_name">
                                <label><div>Last Name</div></label>
                                <input type="text" name="last_name" placeholder='<?php echo $lastname ?>'>
                            </div>
                        </div>
                        <div class="student_email">
                            <div class="iitg_mail">
                                <label><div>IITG Mail</div></label>
                                <input type="email" name="iitg_mail" value='<?php echo $login_email ?>' readonly>
                            </div>
                            <div class="personal_email">
                                <label><div>Personal Email</div></label>
                                <input type="email" name="email" placeholder='<?php echo $email ?>' required>
                            </div>
                        </div>
                        <div class="rollno_mobile">
                            <div class="roll_no">
                                <label><div>Roll No</div></label>
                                <input type="number" name="roll_no" placeholder='<?php echo $rollno ?>' required>
                            </div>
                            <div class="mobile">
                                <label><div>Mobile Number</div></label>
                                <input type="number" name="mobile" placeholder='<?php echo $mobile ?>' required>
                            </div>
                        </div>
                        <div class="gender_dob">
                            <div class="gender" style="display:inline;">
                                <label style="font-size:16px;">Gender</label><br>
                                <?php if($hide) echo "<input type='text' placeholder =$gender >"
                                ?>
                                <input type="radio" name="gender" value='male' <?php echo $hide?> required>
                                <label for="male" <?php echo $hide?>>Male</label>
                                <input type="radio" name="gender" value="female" <?php echo $hide?>>
                                <label for="female" <?php echo $hide?>>Female</label>
                                <input type="radio" name="gender" value="other" <?php echo $hide?>>
                                <label for="other" <?php echo $hide?>>Other</label>
                            </div>
                            <div class="dob">
                                <label><div>Date of Birth</div></label>
                                <input type="text" name="dob" placeholder='<?php echo $dob ?>' onfocus="(this.type='date')" onblur="(this.type='text')" required>
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
                                <select name="department" required>
                                    <option value="" disabled selected><?php echo $department ?></option>
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
                            <div class="course">
                                <label><div>Course</div></label>
                                <select name="course" required>
                                    <option value="" disabled selected><?php echo $course ?></option>
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
                        <div class="cpi_">
                            <div class="cpi">
                                <label><div>CPI</div></label>
                                <input type="text" name="cpi" placeholder='<?php echo $cpi ?>' required>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div>
                        <button class="btn" type="submit" <?php echo $hide?>>save changes</button>
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