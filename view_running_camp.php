<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: login.php");
}
require_once "config.php";
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
      margin-top:3%;
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
    <P style="margin-left:38% ;font-size:20px"> <b>Active Campaigns for Donations</b></p>
</div>

<script>
    function btn_click(id){
        var url = "donate.php?c_id="+id;
        window.location.href=url;
    }
</script>

<div class="container">
    <?php
    // displaying
    $q = "SELECT * FROM active_camp WHERE CURRENT_TIMESTAMP >= start_time AND CURRENT_TIMESTAMP < end_time";
    $r = mysqli_query($conn, $q);

    $count = mysqli_num_rows($r);
    
    
    
    while($count>0){
        echo '<div class="row row-no-gutters">';
        $i = 0;
        $count--;
        while($i<3 && $row = mysqli_fetch_assoc($r)){
            if($row["u_id"] == $_SESSION["u_id"]){
                continue;
            }
            $i++;
            $left_amt = $row["total_amt"] - $row["raised_amt"];
            echo '<div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">'.substr($row["title"],0,30).'...'.'</h5>
                        <p class="card-text">'.substr($row["description"],0,100).'...'.'</p>
                        <p class="card-text" "><b>Remaining:</b> '.$left_amt.'</p>
                        <a href="#" onclick="btn_click('.$row["c_id"].')" class="btn btn-primary box-shadow--6dp">View Campaign</a>
                    </div>
                    </div>
                </div>'
                ;
        }

        echo '</div>';  
    }
    
    ?>
</div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
