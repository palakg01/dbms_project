<?php

  session_start();

  include './db.php';
  $con = createDB();

  $email = $_SESSION['email'];
  $train_no = $_SESSION['train_no'];
  $order_id = $_SESSION['order_id'];
  $amount_paid = $_SESSION['payable_amount'];
  $ticket_id = $_SESSION['ticket_id'];
  $_SESSION['ticket_id'] = $ticket_id;

  $sql = "SELECT * FROM train WHERE train_no='$train_no'";
  $result = mysqli_query($con,$sql);

  if ($row = $result->fetch_assoc()) {
    $price = $row['price'];
    $num_of_passengers = $amount_paid/$price;
    $available_seats = $row['available_seats'];
    $waiting  = $row['waiting'];  

    if($available_seats>=$num_of_passengers){
      $available_seats = $available_seats - $num_of_passengers;
    }
    else{
      $waiting = $waiting + $num_of_passengers - $available_seats;
      $available_seats = 0;
    }
  }

  if($waiting==0){
    $status = 'booked';
  }
  else{
    $status = 'waiting';
  }  

  $sql = "INSERT INTO `ticket` (`ticket_id`,`train_no`,`booked_user`,`order_id`,`booking_status`,`no_of_passengers`) VALUES ('$ticket_id','$train_no','$email','$order_id','$status','$num_of_passengers')";

  $result = mysqli_query($con,$sql);

  if ($result){
    echo '
      <div class="bg-info d-flex justify-content-center align-items-center flex-column container shadow rounded p-4">
        <h1 class="pb-4">Ticket Booked Succesfully!<h1>
        <div style="font-size:20px">
          <p>Train No: '.$train_no.'</p>
          <p>Ticket Id: '.$ticket_id.'</p>
          <p>No of passengers: '.$num_of_passengers.'</p>
          <p>Ticket Status: '.$status.'</p>
        </div>
      </div>
    ';
  }else{
    echo mysqli_error($con);
  }

  $sql = "UPDATE train SET available_seats='$available_seats',waiting=$waiting WHERE train_no='$train_no'";
  $result = mysqli_query($con,$sql);

  if(isset($_POST['dashboard-btn'])){
    unset($_SESSION["train_no"]);
    unset($_SESSION["order_id"]);
    unset($_SESSION["payable_amount"]);
    unset($_SESSION["ticket_id"]);
    unset($_SESSION["src"]);
    unset($_SESSION["destn"]);
    unset($_SESSION["date"]);
    unset($_SESSION["num_of_trains"]);
  }


?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
  <!-- Bootstrap CSS --> 
  <link 
    rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous"
  >  

    <title>Dbms Project</title>
  </head>

  <body>
   
    <div  style="position:absolute;top:20px;right:20px">
        <form method="POST">
          <h3><a href='dashboard.php' class="text-dark border-bottom" name="dashboard-btn">Dashboard</a></h3>
        </form>
    </div>

    <script src="
    https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="
    sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous">
    </script>
        
    <script src="
    https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity=
    "sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous">
    </script>
        
    <script src="
    https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
        integrity=
    "sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous">
    </script> 
  </body>
</html>