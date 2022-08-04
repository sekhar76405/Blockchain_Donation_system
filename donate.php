<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: login.php");
}
if(!isset($_GET['c_id']))
{
  header("location: welcome.php");
}
require_once "config.php";

  $title = $description = $start_time = $end_time = $total_amt = $raised_amt = "";
  $sql = "SELECT title, description, start_time, end_time, total_amt, raised_amt FROM active_camp WHERE c_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt){
    mysqli_stmt_bind_param($stmt, "i", $param_c_id);
    $param_c_id = $_GET["c_id"];

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

//---------------------------------------------------------------------------------------------
  $receiver_addr = "";
  $sql = "SELECT metamaskID FROM users WHERE u_id = (SELECT u_id FROM active_camp WHERE c_id= ? )";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt){
    mysqli_stmt_bind_param($stmt, "i", $param_c_id);
    $param_c_id = $_GET["c_id"];

    if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_store_result($stmt);
      if(mysqli_stmt_num_rows($stmt) == 1){
        
        mysqli_stmt_bind_result($stmt, $receiver_addr);

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
//---------------------------------------SENDER'S ADDRESS--------------------------------------------------
  $sender_addr = "";
  $sql = "SELECT metamaskID FROM users WHERE u_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if($stmt){
    mysqli_stmt_bind_param($stmt, "i", $param_u_id);
    $param_u_id = $_SESSION["u_id"];

    if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_store_result($stmt);
      if(mysqli_stmt_num_rows($stmt) == 1){
        
        mysqli_stmt_bind_result($stmt, $sender_addr);

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
//--------------------------------------------------------------------------
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
        <a class="nav-link" href="welcome.php" style="margin-left:15px;">Home</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="logout.php" style="margin-left:15px;">Logout</a>
      </li>
      
    </ul>
  </div>
</nav>

<div class="container mt-4">
<!-- <h3 style="margin-left:38%">Secure Donation System</h3> -->
<!-- <h3 style="margin-left:41%; margin-top:1%;">Active Campaign</h3> -->
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
    <div style="width:50%;">
        <h4>Remaining Amount</h4>
        <p id="rem_amt" style="font-size:larger; margin-left: 4%;">1000</p>
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
        document.getElementById("rem_amt").innerHTML = total_amt - raised_amt;
    </script>
    <div>
        
        <button type="submit" class="btn btn-primary box-shadow--6dp" data-toggle="modal" data-target="#exampleModalCenter" style="margin-left:9%;  width:30%">Donate</button>
        <a href="view_running_camp.php" class="btn btn-danger box-shadow--6dp"  style="margin-left:9%; width:30%">Back</a>
        
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Donation Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="float: left; width:50%;">
            <h5>Total amount</h5>
            <p id="inner_total_amt" style="font-size:larger; margin-left: 4%;">1000</p>
        </div>
        <div style="margin-left: 60%">
            <h5>Raised amount</h5>
            <p id="inner_raised_amt" style="font-size:larger; margin-left: 3%;">12</p>
        </div>

        <div style="width:50%;">
            <h5>Remaining amount</h5>
            <p id="inner_rem_amt" style="font-size:larger; margin-left: 4%;">1000</p>
            
        </div>

        <script>
            document.getElementById("inner_total_amt").innerHTML = total_amt;
            document.getElementById("inner_raised_amt").innerHTML = raised_amt;
            document.getElementById("inner_rem_amt").innerHTML = total_amt - raised_amt;
        </script>

        <h5>Enter donation amount</h5>
        <input type="number" name="amount" class="form-control" id="amount" aria-describedby="emailHelp" placeholder="Enter Amount" required>
        <p id="invalid_amt" style="color:red;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary box-shadow--6dp" data-dismiss="modal">Close</button>
        <button type="button" onclick="validate_amt()" class="btn btn-primary box-shadow--6dp">Donate</button>
        <script>

          function amtToHex(amount){
            amount = amount * Math.pow(10,12) * 6.4;
            var hex = amount.toString(16);
            var temp = "0x";
            result = temp.concat(hex);
            console.log(result);
            return result;
          }

          function hexToAmt(hex){
            var wei = parseInt(hex, 16);
            var result = wei * 1.5625 * Math.pow(10,-13);
            console.log(hex + "  hex to amt:  " + result);
            return result;
          }
          
           function switchChain(){
                 window.ethereum.request({
                    method: 'wallet_switchEthereumChain',
                    params: [{ chainId: '0x4' }], 
                });
                console.log("Switched Chain");
                
            }
            var balance_amt, transaction_hash = "";
           
            function getBalance(address){
                accounts = ethereum.request({method: 'eth_requestAccounts'});
                account = accounts[0];
                console.log("getBalance()" + address);
                ethereum.request({ method: 'eth_getBalance',
                params: [address, 'latest'],
                })
                .then((quantity) => saveBalance(quantity))
                .catch((error) => console.error);
            }
            function saveBalance(hex){
                balance_amt = hexToAmt(hex);
                console.log("Balance: " + balance_amt);
            }
            function saveHash(hash){
              transaction_hash = hash;
              console.log("Hash: " + transaction_hash);
            }

            async function perform_Transaction(sender, receiver, amount){
                console.log(sender +"  " + receiver);
                await ethereum.request({ method: 'eth_sendTransaction',
                params: [
                    {
                    from: sender,
                    to: receiver,
                    value: amtToHex(amount),
                    },
                ],
                })
                .then((txHash) => saveHash(txHash))
                .catch((error) => console.error);
            }


            async function sendEth(sender, receiver, amount){
            console.log("Entered sendEth");
            if(sender == null || receiver == null || amount == null){
                console.log("Error in sendEth Func, parameter is NULL");
                return ;
            }
            switchChain();
            //check for balance of the Wallet
            getBalance(sender);

              if(amount > balance_amt){

              console.log("Insufficient balance to make donations.!");
              console.log(amount + " " + balance_amt);
              return ;
            }
            else{
              console.log("sufficient Balance");
              await perform_Transaction(sender, receiver, amount);
              checkSuccess();
            }
                       
            
            }
            
             function validate_amt(){
                if(parseInt(document.getElementById("amount").value) <= 0 || parseInt(document.getElementById("amount").value) > parseInt(document.getElementById("inner_rem_amt").innerHTML)){
                    console.log("if");
                    document.getElementById("invalid_amt").innerHTML = "Enter valid amount";
                }
                else{
                    document.getElementById("invalid_amt").innerHTML = "";
                    sendEth("<?php echo $sender_addr?>", "<?php echo $receiver_addr?>", parseInt(document.getElementById("amount").value));
                    return ;
                }
            }
            function checkSuccess(){
              console.log("checkSuccess()");
              if(transaction_hash != ""){
                var url = "donate.php?c_id="+ "<?php echo $_GET["c_id"]?>" + "&" + "u_id="+ "<?php echo $_SESSION["u_id"]?>" + "&" + "amt=" + (document.getElementById("amount").value).toString() +  "&" + "transaction_hash=" + transaction_hash ;
                console.log(url);
                window.location.href=url;
                }
                else{
                  alert("Something went wrong during transaction..");
                }
            }

        </script>
        <?php
            if(isset($_GET["u_id"]) && isset($_GET["c_id"]) && isset($_GET["amt"]) && isset($_GET["transaction_hash"])){
                
                $sql = "INSERT INTO donations (u_id, c_id, amt, time, transaction_hash) VALUES (?, ?, ?, ?, ?)";
                date_default_timezone_set('Asia/Kolkata'); 
                $current_date = date("Y-m-d H:i:s");
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "iiiss", $param_u_id, $param_c_id, $param_amt, $param_time, $param_transaction_hash);

                    // Set these parameters
                    $param_u_id = $_GET["u_id"];
                    $param_c_id = $_GET["c_id"];
                    $param_amt = $_GET["amt"]; 
                    $param_transaction_hash = $_GET["transaction_hash"];
                    
                    $param_time = $current_date;
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Transaction Hash~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

                    // Try to execute the query
                    if (mysqli_stmt_execute($stmt))
                    {
                        echo '<script>alert("Donation Successfull");</script>';
                        echo '<script>window.location.href = "view_running_camp.php";</script>';
                    }
                    else{
                        echo "Something went wrong... cannot donate!";
                    }
                }
                mysqli_stmt_close($stmt);





                // for increasing in the DB of raised amount
                $sql = "UPDATE active_camp SET raised_amt = ? WHERE c_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt)
                {
                    mysqli_stmt_bind_param($stmt, "ii", $param_raised_amt, $param_c_id);

                    // Set these parameters
                    $param_raised_amt = $_GET["amt"] + $raised_amt ;
                    $param_c_id = $_GET["c_id"];
                    

                    // Try to execute the query
                    if (mysqli_stmt_execute($stmt))
                    {
                        //echo '<script>window.location.href = "view_running_camp.php";</script>';
                    }
                    else{
                        echo "Something went wrong... cannot donate!";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            
            
        ?>
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
