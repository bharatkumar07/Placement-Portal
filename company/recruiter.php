<?php

session_start();

if(!isset($_SESSION['c_loggedin']) || $_SESSION['c_loggedin'] !==true)
{
    header("location: rlogin.php");
}

require_once "../config.php";

$login_email = $_SESSION['c_email'];
$hide = "";

$company_name = "Enter Company Name";
$email = $login_email;
$location = "Enter Locations";
$contact = "Enter your Contact No";
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $company_name = trim($_POST["c_name"]);
    $email = trim($_POST["c_email"]);
    $location = trim($_POST["location"]);
    $contact = trim($_POST["contact"]);
    $sql = "INSERT INTO company (c_name, c_email, contact) VALUES ('$company_name', '$email', '$contact')";
    $stmt = $conn->prepare($sql);
    if ($stmt)
    {
        $stmt->execute();

        $cid = "";
        $sql1 = "SELECT companyID FROM company WHERE c_email = '$email'";
        $stmt1 = $conn->prepare($sql1);
        if($stmt1){
            $stmt1->execute();
            if($row = $stmt1->fetch()){
                $cid = $row['companyID'];
            }

            $space = ' ';
            $words = explode($space,$location);
            foreach($words as $loc){
                $sql2 = "INSERT INTO company_location(companyID, location) VALUES ('$cid', '$loc')";
                $conn->exec($sql2);
            }
        }
    }
    $stmt = null;
} 

$sql = "SELECT companyID, c_name, c_email, contact FROM company WHERE c_email = '$login_email'";
$result = $conn->prepare($sql);
$result->execute();
    if($row = $result->fetch()){
        $hide = "display: none";

        $cid = $row["companyID"];
        $company_name = $row["c_name"];
        $email = $row["c_email"];
        $contact = $row["contact"];
        $sql1 = "SELECT location FROM company_location WHERE companyID = '$cid'";
        $result1 = $conn->prepare($sql1);
        $result1->execute();
        $location = "";
        while($row1 = $result1->fetch()){
            $location = $location . $row1['location'] . " ";
        }
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
    <link rel="stylesheet" href="recruiter.css">
</head>
<body>
    <div class="container">
        <span class="open_nav" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <nav class="left">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <ul class="left_list">
                <li class="profile" style="background-color:skyblue;">
                    <a href="recruiter.php">Home</a>
                </li>
                <li class="job">
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
                <h2 class="company_heading">Company Details</h2>
                <div class="company_container">
                    <div class="company_nav">
                        <a href="#">Basic Information</a>
                    </div>
                    <hr>
                    <div class="company_info_container">
                        <div class="companyname_email">
                            <div class="company_name">
                                <label><div>Company Name</div></label>
                                <input type="text" name="c_name" placeholder='<?php echo $company_name ?>' required>
                            </div>
                            <div class="c_email">
                                <label><div>Company Email</div></label>
                                <input type="email" name="c_email" value='<?php echo $email ?>' readonly>
                            </div>
                        </div>
                        <div class="locations">
                            <div class="location" style="">
                                <label><div>Location</div></label>
                                <input type="text" name="location" placeholder='<?php echo $location ?>' required>
                            </div>
                        </div>
                        <div class="contact_">
                            <div class="contact">
                                <label><div>Contact</div></label>
                                <input type="number" name="contact" placeholder='<?php echo $contact ?>' required>
                            </div>
                            
                        </div>
                        <div>
                            <button style="margin-left:0 ; <?php echo $hide?>;" class="btn" type="submit">save changes</button>
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