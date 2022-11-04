<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['role']) && ($_POST['role']) == "student"){
        header("Location: student/student.php"); 
    }

    elseif(isset($_POST['role']) && ($_POST['role']) == "recruiter"){
        header("Location: company/recruiter.php"); 
    }
    else{
            header("Location: index.php"); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement-Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="nav_bar">
        <div class="left_nav">
            <img class="IITG_logo" src="https://swc.iitg.ac.in/placement-portal/static/images/logo.png" alt="IITG Logo">
            <span>Placement Portal</span>
        </div>
        <div class="right_nav">
            <!-- <a href="#"> Click here to login</a> -->
        </div>
    </div>

    <div class="main_container">
        <h1>Welcome To IITG Placement Portal</h1>
        <div class="main_box">
            <p>Select a role</p>
            <form class="select_role" action="" method="POST">
                <input type="radio" id="student" name="role" value="student">
                <label for="student">Student</label><br>
                <input type="radio" id="recruiter" name="role" value="recruiter">
                <label for="recruiter">Recruiter</label><br>
                <button type="submit">Continue</button>
              </form>
        </div>
    </div>

    <footer>
        contacts:
    </footer>
</body>
</html>