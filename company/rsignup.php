<?php
require_once "../config.php";

$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "email cannot be blank";
    }
    else{
        $sql = "SELECT id FROM student_login WHERE s_email = :s_email";
        $stmt = $conn->prepare($sql);
        if($stmt)
        {
            $stmt->bindParam(":s_email", $param_email);

            // Set the value of param email
            $param_email = trim($_POST['email']);

            // Try to execute this statement
            if($stmt->execute()){
                // mysqli_stmt_store_result($stmt);
                if($stmt->rowCount() == 1)
                {
                    $email_err = "This email is already taken"; 
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
        // mysqli_stmt_close($stmt);
    }

    


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $confirm_password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($email_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO student_login (s_email, s_password) VALUES (:s_email, :s_password)";
    $stmt = $conn->prepare($sql);
    if ($stmt)
    {
        $stmt->bindParam(":s_email", $param_email);
        $stmt->bindParam(":s_password", $param_password);

        // Set these parameters
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if ($stmt->execute())
        {
            header("location: rlogin.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    // mysqli_stmt_close($stmt);
}
$conn = null;
}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../styles.css">

    <title>PHP login system!</title>
  </head>
  <body>
  <div class="nav_bar">
        <div class="left_nav">
            <img class="IITG_logo" src="https://swc.iitg.ac.in/placement-portal/static/images/logo.png" alt="IITG Logo">
            <span>Placement Portal</span>
        </div>
        <div class="right_nav">
            <a href="../index.php"> Go Back To Home page</a>
        </div>
    </div>
<div class="main_container">
      <h1>Welcome To IITG Placement Portal</h1>
  <div class="main_box login_box" style="padding-top: 4vh;">
  <h3 style="padding-left:20%;">Please Signup Here:</h3>
  <form action="" method="post">
      <div class="student_login">
        <!-- <label for="email">email</label> -->
        <input type="email" name="email" id="email" placeholder="Email">
        <span> <?php echo "<br>"."<h5>$email_err</h5>"; ?></span>
      </div>
      <div class="student_login">
        <!-- <label for="password">Password</label> -->
        <input type="password" name ="password" id="password" placeholder="Password">
        <span> <?php echo "<br>"."<h5>$password_err</h5>"; ?></span>
      </div>
    <div class="student_login">
        <!-- <label for="confirm_password">Confirm Password</label> -->
        <input type="password" name ="confirm_password" id="confirm_password" placeholder="Confirm Password">
        <span> <?php echo "<br>". "<h5>$confirm_password_err</h5>"; ?></span>
      </div>
    <button type="submit" class="btn">Sign in</button>
  </form>
  <div style="display:flex; font-size:0.7em; padding-left:20%;" class="signup">Already have an account?<a style="padding:0 8px;" class="nav-link" href="rlogin.php">Login</a></div>
  </div>
</div>
</div>
    <footer>
        contacts:
    </footer>
  </body>
</html>
