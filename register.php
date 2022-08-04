<?php
require_once "config.php";

$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = $phonenumber_err = "";


if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Email cannot be blank";
        
    }
    else{
        $sql = "SELECT u_id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        //checking if email already ther
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST['email']);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = "Sorry! This email already exists"; 
                }
                else{
                    $email = trim($_POST['email']);
                }
            }
            else{
                echo "stmt execution went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    }


// for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
    
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
    
}
else{
    $password = trim($_POST['password']);
}

// for confirm password
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
    
}

// for phonenumber
if(empty(trim($_POST['phonenumber']))){
  $phonenumber_err = "Phone Number cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 10){
  $phonenumber_err = "Phone Number cannot be less than 5 characters";
}


// If there were no errors, go ahead and insert into the database
if(empty($email_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (email, password, firstname, lastname, phonenumber, metamaskID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssssis", $param_email, $param_password, $param_firstname, $param_lastname, $param_phonenumber, $param_metamaskID);

        // Set these parameters
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_firstname = trim($_POST["firstname"]);
        $param_lastname = trim($_POST["lastname"]);
        $param_phonenumber = trim($_POST["phonenumber"]);
        $param_metamaskID = trim($_POST["metamaskID"]);
        

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
else{
  echo "Unable to Register because of the following error: ". $email_err . " " . $password_err . " " . $confirm_password_err . " " . $phonenumber_err; 
}
mysqli_close($conn);
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
    <script type="text/javascript">
      
      function validate(){
        
        console.log("hii");
        var emailID = document.registerform.email.value;
        atpos = emailID.indexOf("@");
        dotpos = emailID.lastIndexOf(".");
        if (atpos < 1 || ( dotpos - atpos < 2 )) {
          document.getElementById("email_err").innerHTML = "invalid email address";
          return false;
        }else{
          document.getElementById("email_err").innerHTML = "";
        }

        if(document.registerform.phonenumber.value.length != 10 ){
          document.getElementById("phonenumber_err").innerHTML = "invalid phone number";
          return false;
        }else{
          document.getElementById("phonenumber_err").innerHTML = "";
        }

        if(document.registerform.password.value.length < 5){
          document.getElementById("pass_err").innerHTML = "less than 5 characters";
          return false;
        }else{
          document.getElementById("pass_err").innerHTML = "";
        }

        if(document.registerform.password.value != document.registerform.confirm_password.value ){
          document.getElementById("confirm_pass_err").innerHTML = "passwords dont match";
          return false;
        }else{
          document.getElementById("confirm_pass_err").innerHTML = "";
        }

        if(document.registerform.metamaskID.value.length < 40 || document.registerform.metamaskID.value == "" ){
          document.getElementById("metamaskID_err").innerHTML = "Invalid Wallet Address";
          return false;
        }
        else{
          document.getElementById("metamaskID_err").innerHTML = "";
          document.getElementById("metamaskID").disabled = false;
        }

        return (true);
      }
      document.getElementById("metamaskID").value = ""; 
      async function getAddress(){
     
        if (typeof window.ethereum == 'undefined') {
          console.log('MetaMask is not installed!');
          document.getElementById("metamaskID_err").innerHTML = "MetaMask Wallet Not detected";
          return ; 
        }
          accounts = await ethereum.request({method: 'eth_requestAccounts'});
          account = accounts[0];
          console.log(account);
          document.getElementById("metamaskID").value = account; 
      }

    </script>



  </head>
  <body style="background-color: #FFFBE7;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.html"><b>Secure Donation System</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left:980px; font-size:20px;">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html" style="margin-left:15px;">Home </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="register.php" style="margin-left:15px;">Register</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="login.php" style="margin-left:15px;">Login</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3 style="margin-left:38%">Please register here</h3>
<div style="width:90%; margin-left:5%; margin-top:5%;">
<form action="" name ="registerform" method="post" onsubmit="return(validate());">
<div class="form-row" >
    <div class="form-group col-md-6" >
      <label for="inputCity"><b>First Name</b></label>
      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required >
    </div>
    <div class="form-group col-md-6" >
      <label for="inputCity"><b>Last Name</b></label>
      <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required >
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6" >
      <label for="inputEmail4"><b>Email</b></label>
      <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
      <p id="email_err" style="color:red;"></p>
    </div>
    
    <div class="form-group col-md-6" >
      <label for="inputEmail4"><b>Phone Number</b></label>
      <input type="number" class="form-control" name="phonenumber" id="phonenumber" placeholder="Enter 10 digit Mobile Number" required>
      <p id="phonenumber_err" style="color:red;"></p>
    </div>
    <div class="form-group col-md-6" >
      <label for="inputPassword4"><b>Password</b></label>
      <input type="password" class="form-control" name ="password" id="password" placeholder="Enter Minimum 5 characters" required>
      <p id="pass_err" style="color:red;"></p>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4"><b>Confirm Password</b></label>
      <input type="password" class="form-control" name ="confirm_password" id="inputPassword" placeholder="Confirm Password" required>
      <p id="confirm_pass_err" style="color:red;"></p>
    </div>
  </div>


  <div class="form-row">
    <div class="form-group col-md-6" >
      <label for="inputCity"><b>MetaMask ID</b></label>
      <div class="form-row">
      <input type="text" class="form-control" style="width:80%;" name="metamaskID" id="metamaskID" placeholder="Connect with your MetaMask Wallet" disabled required>
      <button type="button" class="btn btn-info" style="margin-bottom:1%; margin-left:3%;" onclick="getAddress()">Connect</button>
      <p id="metamaskID_err" style="color:red;"></p>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-primary box-shadow--6dp" style="margin-top:1%; width:30%;margin-left:35%;">Sign up</button>
</form>
</div>
<p style="font-size:20px; margin-top: 12px; margin-left:42%"><b> Already a User?</b> <a href="login.php"> login</a></p>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
