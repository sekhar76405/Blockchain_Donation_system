<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['email']))
{
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$email = $password = $firstname = $lastname = $phonenumber = $metamaskID = "";
$err = "";
$invalid_email = $invalid_pass = 0;

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
  if(empty(trim($_POST['email'])) || empty(trim($_POST['password'])))
  {
    $err = "One of the fields is missing in email or password";
  }
  else{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
  }


  if(empty($err))
  {
    $sql = "SELECT u_id, email, password, firstname, lastname, phonenumber, metamaskID FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_email);
    $param_email = $email;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
            mysqli_stmt_bind_result($stmt, $u_id, $email, $hashed_password, $firstname, $lastname, $phonenumber, $metamaskID);
            if(mysqli_stmt_fetch($stmt))
            {
                if(password_verify($password, $hashed_password))
                {
                  echo "Success";
                  // this means the password is corrct. Allow user to login
                  session_start();
                  $_SESSION["u_id"] = $u_id;
                  $_SESSION["loggedin"] = true;
                  $_SESSION["email"] = $email;
                  $_SESSION["password"] = $password;
                  $_SESSION["firstname"] = $firstname;
                  $_SESSION["lastname"] = $lastname;
                  $_SESSION["phonenumber"] = $phonenumber;
                  $_SESSION["metamaskID"] = $metamaskID;

                  //Redirect user to welcome page
                  header("location: welcome.php");
                }
                else{
                  $invalid_pass = 1;
                }
            }
        }
        else{
            $invalid_email = 1;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <title>Project-Secure Donations</title>
    <style>
      .box-shadow--6dp {
    box-shadow: 0 6px 10px 0 rgba(0, 0, 0, .14), 0 1px 18px 0 rgba(0, 0, 0, .12), 0 3px 5px -1px rgba(0, 0, 0, .2)
    }
    </style>
    <script type = "text/javascript">
      invalid_format_email = 0;
        function validate(){
          //console.log("in func");
        var emailID = document.loginform.email.value;
        atpos = emailID.indexOf("@");
        dotpos = emailID.lastIndexOf(".");
        if (atpos < 1 || ( dotpos - atpos < 2 )) {
          //document.getElementById("invalid_email").innerHTML = "invalid email ID";
          invalid_format_email = 1;
          check_invalid_email();
          return false;
        }
        else{
          invalid_format_email = 0;
        }
        return ( true );
      }

      function check_invalid_email(){
          if(invalid_format_email == 1){
          document.getElementById("invalid_email").innerHTML = "invalid email ID";
        }
        else{
          document.getElementById("invalid_email").innerHTML = "";
        }
      }  
    </script>


  </head>
  <body style="background-color: #FFFBE7;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.html"> <b> Secure Donation System </b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left:980px; font-size:20px;">
  <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="index.html" style="margin-left:15px;">Home</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="register.php" style="margin-left:15px;">Register</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="login.php" style="margin-left:15px;">Login</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3 style="margin-left:46%">Please login here</h3>

<div style="width:50%; margin-left:30%; margin-top:5%;">
<form action="" method="post" name="loginform" onsubmit="return(validate());">
  <div class="form-group" style="margin-top:5%;">
    <label for="exampleInputEmail1"><b>Email ID</b></label>
    <input type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Email Id" required>
    <p id="invalid_email" style="color:red;"></p>
    <script>
      <?php
        echo "var invalid_email ='$invalid_email';";
      ?>
      //console.log(invalid_pass);
      if(invalid_email == 1){
        document.getElementById("invalid_email").innerHTML = "Email not found";
      }
      else{
        document.getElementById("invalid_email").innerHTML = "";
      }
    </script>
  </div>
  <div class="form-group" style="margin-top:5%;">
    <label for="exampleInputPassword1"><b>Password</b></label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required>
    <p id="invalid_pass" style="color:red;"></p>
    <script>
      <?php
        echo "var invalid_pass ='$invalid_pass';";
      ?>
      //console.log(invalid_pass);
      if(invalid_pass == 1){
        document.getElementById("invalid_pass").innerHTML = "wrong password";
      }
      else{
        document.getElementById("invalid_pass").innerHTML = "";
      }
    </script>
    <br>
    <input type="checkbox"  style=" margin-left : 5px ;width: 15px;height: 15px;" onclick="myFunction()"><b> Show Password</b>

    <script>
    function myFunction() {
      var x = document.getElementById("exampleInputPassword1");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    </script>

  </div>

  <button type="submit" class="btn btn-primary box-shadow--6dp" style="margin-left:35%; margin-top:2%;width:30%">Login</button>
</form>

<p style="font-size:20px; margin-top: 10px; margin-left:20%"> <b> Not yet registered?</b> <a href="register.php"> create an account</a></p>

</div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
