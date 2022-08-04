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
<!-- 
<div class="container mt-4">
<h3 style="margin-left:38%">Secure Donation System</h3>
<P style="margin-left:42% ;font-size:20px"> <b> Hi <?php echo $_SESSION["firstname"]?>, welcome</b></p>
<div class="row">
  <div class="col-sm-6">


<br>
<button type="button" class="btn btn-primary" onclick="check_running_camp()" name="button" style="margin-left:40%; width:45%;height:15%; margin-top:10%;font-size:20px;">
<b>Donate Now</b>
</button>
<br>
<script type="text/javascript">
  function check_running_camp(){
    var running_camp = 0; // assuming no running campaigns exist
    <?php 
      if(!isset($_SESSION["u_id"])){
        header("location: login.php");
      }  
      $running_camp = 0;// assuming no running campaigns exist
      $sql = "SELECT c_id FROM active_camp";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 0){
            $running_camp = 0;
          }else{
            $running_camp = 1;
          }
        }else{
          echo "Statement execution went wrong";
        }
        mysqli_stmt_close($stmt);
      }else{
        echo "Statement preparation went wrong.";
      }

    ?>
    <?php echo "var running_camp ='$running_camp';"?>
    if(running_camp == 1){
        console.log("running campaigns exist"); // success
        window.location.href = "view_running_camp.php";
    }else{
      alert("Sorry, No running campaigns available to donate for now.");
    }
  }

</script>
<button type="button" class="btn btn-primary" name="create_camp" onclick="check_camp_already_exists()" style="margin-left:40%; width:45%;height:15%; margin-top:10% ;font-size:20px;">
  <b>Create New Campaign</b>
</button>
<script type="text/javascript">
  function check_camp_already_exists(){
    var camp_exists = 1; // assuming it exists
    <?php 
      if(!isset($_SESSION["u_id"])){
        header("location: login.php");
      }  
      $camp_exists = 1;// assuming froom start that it exists
      $sql = "SELECT c_id FROM active_camp WHERE u_id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
        mysqli_stmt_bind_param($stmt, "i", $param_u_id);
        $param_u_id = $_SESSION["u_id"];

        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 0){
            $camp_exists = 0;
          }else{
            $camp_exists = 1;
          }
        }else{
          echo "Statement execution went wrong";
        }
        mysqli_stmt_close($stmt);
      }else{
        echo "Statement preparation went wrong.";
      }

    ?>
    <?php echo "var camp_exists ='$camp_exists';"?>
    if(camp_exists == 0){
        console.log("can create a campaign"); // success
        window.location.href = "new_campaign.php";
    }else{
      alert("You cannot start a new campaign as you already have an active campaign running");
    }


  }

</script>
<br>
<button type="button"class="btn btn-primary" onclick="check_active_camp()" name="button" style="margin-left:40%; width:45%; height:15%; margin-top:10%;font-size:20px;">
<b>  Your Active Campaign </b>
</button>
<script type="text/javascript">
  function check_active_camp(){
    var active_camp = 0; // assuming it doesnt exists
    <?php 
      if(!isset($_SESSION["u_id"])){
        header("location: login.php");
      }  
      $active_camp = 0;// assuming froom start that it doesnt exists
      $c_id = -1;
      $sql = "SELECT c_id FROM active_camp WHERE u_id = ?";
      $stmt = mysqli_prepare($conn, $sql);
      if($stmt){
        mysqli_stmt_bind_param($stmt, "i", $param_u_id);
        $param_u_id = $_SESSION["u_id"];

        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1){
            $active_camp = 1;
            mysqli_stmt_bind_result($stmt, $c_id);

            mysqli_stmt_fetch($stmt); 
            $_SESSION["c_id"] = $c_id;
            //echo $c_id;
          }else{
            $active_camp = 0;
          }
        }else{
          echo "Statement execution went wrong";
        }
        mysqli_stmt_close($stmt);
      }else{
        echo "Statement preparation went wrong.";
      }

    echo "var active_camp ='$active_camp';";
    echo "var c_id ='$c_id';";
    
    ?>
    if(active_camp == 1){  
      window.location.href = "active_camp.php";
    }else{
      alert("You do not have an active campaign running");
    }
  }

</script>

  </div>
  <div class="col-sm-6">
    <div class="card" style="overflow: scroll; height : 300px;">

      <div class="container">
        <h4 style="margin-left:32%;margin-top:2%"><b>Previous donations</b></h4>
        <ul style="list-style-type:none;">

        
           <?php 
            $q = "SELECT * FROM (SELECT donations.u_id, active_camp.c_id, active_camp.title, active_camp.description, donations.amt, donations.transaction_hash, donations.time FROM active_camp INNER JOIN donations ON active_camp.c_id = donations.c_id) as T WHERE T.u_id = ?";
            // $stmt = mysqli_prepare($conn, $q);
            // mysqli_stmt_bind_param($stmt, "i", $param_u_id);
            // $param_u_id = $_SESSION["u_id"];
            // mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);


            $stmt = $conn->prepare($q); 
            $stmt->bind_param("i", $param_u_id);
            $param_u_id = $_SESSION["u_id"];
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            //$user = $result->fetch_assoc(); 

            while($row = $result->fetch_assoc()){
              echo '<br>
                    <li><p> Amount '.$row["amt"].' donated to '.$row["title"].' Transaction Hash: '.$row["transaction_hash"].'</p></li>
              ';
            }
          ?>  
          <!-- <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>   -->
          </ul>
      </div>
    </div>
  <!-- </div> -->

  <div class="container mt-4">
<h3 style="margin-left:36%">Secure Donation System</h3>
<P style="margin-left:41% ;font-size:20px"> <b> Hi <?php echo $_SESSION["firstname"]?>, welcome</b></p>
<div class="container" style="margin-left:3%;">
<div class="row">
  <div class="col-sm">


    <br>
    <button type="button" class="btn btn-primary box-shadow--6dp" onclick="check_running_camp()" name="button" style=" width:80%;height:50%; margin-top:10%;font-size:20px;">
    <b>Donate Now</b>
    </button>
    <script type="text/javascript">
      function check_running_camp(){
        var running_camp = 0; // assuming no running campaigns exist
        <?php 
          if(!isset($_SESSION["u_id"])){
            header("location: login.php");
          }  
          $running_camp = 0;// assuming no running campaigns exist
          $sql = "SELECT c_id FROM active_camp";
          $stmt = mysqli_prepare($conn, $sql);
          if($stmt){
            if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 0){
                $running_camp = 0;
              }else{
                $running_camp = 1;
              }
            }else{
              echo "Statement execution went wrong";
            }
            mysqli_stmt_close($stmt);
          }else{
            echo "Statement preparation went wrong.";
          }

        ?>
        <?php echo "var running_camp ='$running_camp';"?>
        if(running_camp == 1){
            console.log("running campaigns exist"); // success
            window.location.href = "view_running_camp.php";
        }else{
          alert("Sorry, No running campaigns available to donate for now.");
        }
      }

    </script>
  </div>
  <div class="col-sm">
    <button type="button" class="btn btn-primary box-shadow--6dp" name="create_camp" onclick="check_camp_already_exists()" style=" width:80%;height:50%; margin-top:17% ;font-size:20px;">
      <b>Create New Campaign</b>
    </button>
    <script type="text/javascript">
      function check_camp_already_exists(){
        var camp_exists = 1; // assuming it exists
        <?php 
          if(!isset($_SESSION["u_id"])){
            header("location: login.php");
          }  
          $camp_exists = 1;// assuming froom start that it exists
          $sql = "SELECT c_id FROM active_camp WHERE u_id = ?";
          $stmt = mysqli_prepare($conn, $sql);
          if($stmt){
            mysqli_stmt_bind_param($stmt, "i", $param_u_id);
            $param_u_id = $_SESSION["u_id"];

            if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 0){
                $camp_exists = 0;
              }else{
                $camp_exists = 1;
              }
            }else{
              echo "Statement execution went wrong";
            }
            mysqli_stmt_close($stmt);
          }else{
            echo "Statement preparation went wrong.";
          }

        ?>
        <?php echo "var camp_exists ='$camp_exists';"?>
        if(camp_exists == 0){
            console.log("can create a campaign"); // success
            window.location.href = "new_campaign.php";
        }else{
          alert("You cannot start a new campaign as you already have an active campaign running");
        }
      }

    </script>
  </div>
  <div class="col-sm">
    <button type="button"class="btn btn-primary box-shadow--6dp" onclick="check_active_camp()" name="button" style=" width:80%; height: 50%; margin-top:17%;font-size:20px;">
    <b>  Your Active Campaign </b>
    </button>
    <script type="text/javascript">
      function check_active_camp(){
        var active_camp = 0; // assuming it doesnt exists
        <?php 
          if(!isset($_SESSION["u_id"])){
            header("location: login.php");
          }  
          $active_camp = 0;// assuming froom start that it doesnt exists
          $c_id = -1;
          $sql = "SELECT c_id FROM active_camp WHERE u_id = ?";
          $stmt = mysqli_prepare($conn, $sql);
          if($stmt){
            mysqli_stmt_bind_param($stmt, "i", $param_u_id);
            $param_u_id = $_SESSION["u_id"];

            if(mysqli_stmt_execute($stmt)){
              mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1){
                $active_camp = 1;
                mysqli_stmt_bind_result($stmt, $c_id);

                mysqli_stmt_fetch($stmt); 
                $_SESSION["c_id"] = $c_id;
                //echo $c_id;
              }else{
                $active_camp = 0;
              }
            }else{
              echo "Statement execution went wrong";
            }
            mysqli_stmt_close($stmt);
          }else{
            echo "Statement preparation went wrong.";
          }

        echo "var active_camp ='$active_camp';";
        echo "var c_id ='$c_id';";
        
        ?>
        if(active_camp == 1){  
          window.location.href = "active_camp.php";
        }else{
          alert("You do not have an active campaign running");
        }
      }

    </script>
  </div>
  <!-- <div class="col-sm-6">
    <div class="card" style="overflow: scroll; height : 300px;">

      <div class="container">
        <h4 style="margin-left:32%;margin-top:2%"><b>Previous donations</b></h4>
        <ul style="list-style-type:none;">

        
           <?php 
            $q = "SELECT * FROM (SELECT donations.u_id, active_camp.c_id, active_camp.title, active_camp.description, donations.amt, donations.transaction_hash, donations.time FROM active_camp INNER JOIN donations ON active_camp.c_id = donations.c_id) as T WHERE T.u_id = ?";
            // $stmt = mysqli_prepare($conn, $q);
            // mysqli_stmt_bind_param($stmt, "i", $param_u_id);
            // $param_u_id = $_SESSION["u_id"];
            // mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);


            $stmt = $conn->prepare($q); 
            $stmt->bind_param("i", $param_u_id);
            $param_u_id = $_SESSION["u_id"];
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            //$user = $result->fetch_assoc(); 

            while($row = $result->fetch_assoc()){
              echo '<br>
                    <li><p> Amount '.$row["amt"].' donated to '.$row["title"].' Transaction Hash: '.$row["transaction_hash"].'</p></li>
              ';
            }
          ?>  
          <br>
          <li>
          <p> Amount 1 donated to wken Transaction Hash: 0xdca2f86903b40e260e71815fb27277e47085b1564c1f8ba78de398465f4cea88</p>
          </li>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>
          <li>NULL</li>
          <br>  
          </ul>
      </div>

    </div>
  </div> -->
</div>
</div>

  <div class="card" style="overflow: scroll; height : 325px; width: 1050px; margin-top:5%; margin-left:3%;">
      <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Campaign Name</th>
          <th scope="col">Amount</th>
          <th scope="col">Transaction Hash</th>
        </tr>
      </thead>
      <tbody>

          <?php
          $q = "SELECT * FROM (SELECT donations.u_id, active_camp.c_id, active_camp.title, active_camp.description, donations.amt, donations.transaction_hash, donations.time FROM active_camp INNER JOIN donations ON active_camp.c_id = donations.c_id) as T WHERE T.u_id = ?";
            // $stmt = mysqli_prepare($conn, $q);
            // mysqli_stmt_bind_param($stmt, "i", $param_u_id);
            // $param_u_id = $_SESSION["u_id"];
            // mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);


            $stmt = $conn->prepare($q); 
            $stmt->bind_param("i", $param_u_id);
            $param_u_id = $_SESSION["u_id"];
            $stmt->execute();
            $result = $stmt->get_result(); // get the mysqli result
            //$user = $result->fetch_assoc();
            $count = 0; 
      while($row = $result->fetch_assoc()){
        $count = $count +1;
        echo "
              <tr>
              <th scope='row'>".$count."</th>
              <td>".$row["title"]."</td>
              <td>".$row["amt"]."</td>
              <td>".$row["transaction_hash"]."</td>
              </tr>";
              
            }
            ?>
        
      </tbody>
    </table>
  </div>
  <p style="margin-left: 25%; margin-top: 2.6%">To Verify your donation, copy the Transaction Hash and search on <a href="https://rinkeby.etherscan.io/" target="_blank">block explorer</a></p>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
