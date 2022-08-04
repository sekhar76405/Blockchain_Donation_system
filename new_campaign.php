<?php 

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: login.php");
}
require_once "config.php";
  
if ($_SERVER['REQUEST_METHOD'] == "POST"){

 
  // if email is empty
  if(!isset($_SESSION["u_id"])){
      echo "User Logged out";
      header("location: login.php");
  }
  else{
    
      $sql = "INSERT INTO active_camp (u_id, title, description, start_time, end_time, total_amt, raised_amt) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_report(MYSQLI_REPORT_ALL);
      
    
      //checking if email already ther
      if($stmt)
      {
          mysqli_stmt_bind_param($stmt, 'issssii', $param_u_id, $param_title, $param_description, $param_start_time, $param_end_time, $param_total_amt, $param_raised_amt);

          $param_u_id = $_SESSION["u_id"];
          $param_title = trim($_POST["title"]) ;
          $param_description = trim($_POST["description"]);
          $param_start_time = trim($_POST["start_time"]);
          $param_end_time = trim($_POST["end_time"]);
          $param_total_amt = trim($_POST["total_amt"]);
          $param_raised_amt = 0;
        
          // Try to execute the query
          if (mysqli_stmt_execute($stmt))
          {
            header("location: welcome.php");
          }
          else{
            echo "Something went wrong... cannot redirect!";
          }
          mysqli_stmt_close($stmt);
      }
      else{
        echo"Statement cannot be prepared";
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
    <style>
    .card {
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      width: 100%;
      margin-top:10%;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .box-shadow--6dp {
    box-shadow: 0 6px 10px 0 rgba(0, 0, 0, .14), 0 1px 18px 0 rgba(0, 0, 0, .12), 0 3px 5px -1px rgba(0, 0, 0, .2)
    }
    .container {
      padding: 2px 16px;
    }
    </style>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <title>Project-Secure Donations</title>
    <script type="text/javascript">
      
      function validate(){
        var st = document.getElementById("start_time").value;
        var et = document.getElementById("end_time").value;
        if(st < '<?php date_default_timezone_set('Asia/Kolkata'); echo date("Y-m-d H:i:s");?>' ){
          //console.log("if 2");
          document.getElementById("st_err").innerHTML = "Invalid Start time.";
          return false;
        }
        else{
          document.getElementById("st_err").innerHTML = "";
        }

        if(et<=st){
          //console.log("if");
          document.getElementById("et_err").innerHTML = "End time should be greater than Start time.";
          return false;
        }
        else{
          document.getElementById("et_err").innerHTML = "";
        }
        
       
       return ( true );
      }
      

    </script>

  </head>
  <body style="background-color: #FFFBE7;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><b>Secure Donation System</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left:980px; font-size:20px;">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome.php" style="margin-left:15px;">Home </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="logout.php" style="margin-left:15px;">Logout</a>
      </li>
      
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3 style="margin-left:38%">Secure Donation System</h3>

<div class="container mt-4">
<h3 style="margin-left:38%">Create new Campaign</h3>
<div style="width:90%; margin-left:15%; margin-top:3%;">
  <form action="" name ="registerform" method="post" onsubmit="return(validate());">
  <div class="form-row" >
      <div class="form-group col-md-6" >
        <label for="inputCity"><b>Title</b></label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Enter the Title of the Campaign" required >
      </div>

    </div>

    <div class="form-row">
      <div class="form-group col-md-6" >
        <label for="inputEmail4"><b>Description</b></label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Enter upto 500 words" style="width: 792px;" required >
        <p id="email_err" style="color:red;"></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6" >
        <label for="inputEmail4"><b>Start Time</b></label>
        <input type="datetime-local" class="form-control" id="start_time" name="start_time" style="width: 300px; " required>      
        <p id="st_err" style="color:red;"></p>
      </div>
      <div class="form-group col-md-6" >
        <label for="inputEmail4"><b>End Time</b></label>
        <input type="datetime-local" class="form-control" id="end_time" name="end_time" style="width: 300px;" required>  
        <p id="et_err" style="color:red;"></p>    
      </div>
    </div>
    
    <div class="form-row" >
      <div class="form-group col-md-6" >
        <label for="inputCity"><b>Amount Required</b></label>
        <input type="number" class="form-control" name="total_amt" id="total_amt" placeholder="Amount required for the cause." style="width: 300px;" required >
      </div>
    </div>

    <button type="submit"  class="btn btn-primary box-shadow--6dp" style="margin-top:1%; width:20%;margin-left:30%; font-size:large">Create</button>
  </form>
</div>
<p style="font-size:20px; margin-top: 12px; margin-left:42.5%"> <a href="login.php"> Return Back to home</a></p>
</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
