<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['email']))
{
    header("location: student.php");
    exit;
}
require_once "../config.php";

$email = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['email'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter email + password</br>";
    }
    else{
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, s_email, s_password FROM student_login WHERE s_email = '$email'";
    $stmt = $conn->prepare($sql);
    
    // Try to execute this statement
    if($stmt->execute()){
        // mysqli_stmt_store_result($stmt);
        if($stmt->rowCount() == 1)
                {
                    // mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if($row=$stmt->fetch()){ //for each result, do the following
                      $id=$row['id'];
                      $email=$row['s_email'];
                      $hashed_password=$row['s_password'];
                 }
                    
                    if($stmt->fetch())
                    $param_password = password_hash($password, PASSWORD_DEFAULT);
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["email"] = $email;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: student.php");
                            
                        }
                        else {
                          $err = "Wrong Password Please try again.</br>";
                        }
                    }

                }
                else{
                  $err = "No such user exist</br>";
                }

    }
}    


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
  <div class="main_box login_box">
  <h3 style="padding-left:20%;" >Please Login Here:</h3>

  <form action="" method="post">
    <div class="student_login">
      <!-- <label for="email">email</label> -->
      <input type="email" name="email" id="email" placeholder="email">
    </div>
    <div class="student_login">
      <!-- <label for="password">Password</label> -->
      <input type="password" name="password" id="password" placeholder="Password">
      <span> <?php echo"<br>". "<h5>$err</h5>"?></span>
    </div>
    <button type="submit" class="btn">Submit</button>
  </form>
  <div style="display:flex; font-size:0.8em; padding-left:20%;" class="signup">New User?<a style="padding:0 8px;" class="nav-link" href="signup.php">Signup</a></div>
  </div>
</div>

</div>
    <footer>
        contacts:
    </footer>
  </body>
</html>
