<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: login.php");
}
require_once "config.php";

if(!isset($_SESSION["c_id"])){
    header("location: welcome.php");
  }  
  $title = $description = $start_time = $end_time = $total_amt = $raised_amt = "";
  $sql = "SELECT title, description, start_time, end_time, total_amt, raised_amt FROM active_camp WHERE c_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt){
    mysqli_stmt_bind_param($stmt, "i", $param_c_id);
    $param_c_id = $_SESSION["c_id"];

    if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_store_result($stmt);
      if(mysqli_stmt_num_rows($stmt) == 1){
        
        mysqli_stmt_bind_result($stmt, $title, $description, $start_time, $end_time, $total_amt, $raised_amt);

        mysqli_stmt_fetch($stmt); 
        
      }else{
        echo "Fetching error";
      }
    }else{
      echo "Statement execution went wrong";
    }
    mysqli_stmt_close($stmt);
  }else{
    echo "Statement preparation went wrong.";
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

    <title>Project-Secure Donations</title>
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>

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
        <a class="nav-link" href="welcome.php" style="margin-left:15px;">Home</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="logout.php" style="margin-left:15px;">Logout</a>
      </li>
      
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3 style="margin-left:38%">Secure Donation System</h3>
<h3 style="margin-left:41%; margin-top:1%;">Active Campaign</h3>
<br>
<div style="margin-left: 18%; margin-top: 0%">
    <h4>Title: </h4>
    <p id="title" style="font-size:larger; margin-left: 2%;"></p>
    
    <div >
        <h4>Description: </h4>
        <p id="description" style="font-size: large;margin-left: 2%; height : 180px; width: 750px; overflow-y:scroll ">fhiwfiohigufjkwfgw wefhiwfiohigufjkwfgw fkufwiuf wefhiwfiohigu;</p>
    </div>
    <div style="float: left; width:50%;">
        <h4>Start Time</h4>
        <p id="start_time" style="font-size:larger;  margin-left: 4%;">10:210</p>
    </div>
    <div style="margin-left: 60%">
        <h4>End Time</h4>
        <p id="end_time" style="font-size:larger; margin-left: 3%;">123</p>
    </div>
    <div style="float: left; width:50%;">
        <h4>Total Amount</h4>
        <p id="total_amt" style="font-size:larger; margin-left: 4%;">1000</p>
    </div>
    <div style="margin-left: 60%">
        <h4>Raised Amount</h4>
        <p id="raised_amt" style="font-size:larger; margin-left: 3%;">12</p>
    </div>
    <script>
        <?php
            echo "var title = '$title';";
            echo "var description = '$description';";
            echo "var start_time = '$start_time';";
            echo "var end_time = '$end_time';";
            echo "var total_amt = '$total_amt';";
            echo "var raised_amt = '$raised_amt';";
        ?>

        document.getElementById("title").innerHTML = title;
        document.getElementById("description").innerHTML = description;
        document.getElementById("start_time").innerHTML = start_time;
        document.getElementById("end_time").innerHTML = end_time;
        document.getElementById("total_amt").innerHTML = total_amt;
        document.getElementById("raised_amt").innerHTML = raised_amt;
    </script>
    <div>
        <!-- <button type="submit" class="btn btn-primary" style="margin-left:9%;  width:30%">View Donations</button> -->
        <button type="submit" class="btn btn-danger box-shadow--6dp" data-toggle="modal" data-target="#exampleModalCenter" style="margin-left:25%; width:30%">End Campaign</button>
    </div>

  

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="color:red;" id="exampleModalLongTitle">End Campaign</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure, you want to end this campaign?</p>
          </div>

          <script>
            // we have to first have store this into prev_camp table before deleting
            function delete_camp(){
              var url = "active_camp.php?del=true" ;
              console.log(url);
              window.location.href=url;
              <?php 
              $deleted = false;
                if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["del"])){

                  //send to prev_camp with updated end time
                  $sql = "INSERT INTO prev_camp (u_id, title, description, start_time, end_time, total_amt, raised_amt) VALUES (?, ?, ?, ?, ?, ?, ?)";
                  $stmt = mysqli_prepare($conn, $sql);
                  mysqli_report(MYSQLI_REPORT_ALL);
                  
                  
                  if($stmt)
                  {
                    mysqli_stmt_bind_param($stmt, 'issssii', $param_u_id, $param_title, $param_description, $param_start_time, $param_end_time, $param_total_amt, $param_raised_amt);

                    $param_u_id = $_SESSION["u_id"];
                    $param_title = trim($title) ;
                    $param_description = trim($description);
                    $param_start_time = trim($start_time);
                    date_default_timezone_set('Asia/Kolkata'); 
                    $param_end_time = trim(date("Y-m-d H:i:s"));
                    $param_total_amt = trim($total_amt);
                    $param_raised_amt = trim($raised_amt);
                  
                    // Try to execute the query
                    if (!(mysqli_stmt_execute($stmt)))
                    {
                      echo "Something went wrong... stmt not executed!";
                    }
                    mysqli_stmt_close($stmt);
                  }
                  else{
                    echo"Statement cannot be prepared";
                  } 


                  //delete from active_camp
                  $sql = "DELETE FROM active_camp WHERE c_id = ?";
                  $stmt = mysqli_prepare($conn, $sql);
                  echo "var a = true;";
                  mysqli_stmt_bind_param($stmt, "i", $param_c_id);
                  $param_c_id = $_SESSION["c_id"];

                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_close($stmt);
                  $deleted = true;
                }
                ?>
            }
            <?php
            if($deleted)
            echo 'window.location.href="welcome.php";'; ?>
          </script>

          <div class="modal-footer">
            <button type="button" class="btn btn-primary box-shadow--6dp" data-dismiss="modal">No</button>
            <button type="button" onclick="delete_camp()" class="btn btn-danger box-shadow--6dp">Yes</button>
          </div>


          
          
        </div>
      </div>
    </div>

  </div>

</div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
