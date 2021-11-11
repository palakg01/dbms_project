<?php
  session_start();

  include 'db.php';
  $con = createDB();

  $train_no = $_SESSION['train_no'];
  $date = $_SESSION['date'];

  $sql = "SELECT * FROM train WHERE train_no='$train_no'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);

  if($count == 1){  
    $src = $row['src'];
    $destn = $row['destn'];
    $email = $_SESSION['email'];
    
  }  

  else{  
    echo ' <div class="alert alert-danger 
      alert-dismissible fade show" role="alert">
      Sorry! We encountered some technical issue! Please try again!
      <button type="button" class="close" 
      data-dismiss="alert" aria-label="Close"> 
      <span aria-hidden="true">×</span> 
      </button>
      </div> 
    '; 
  }
 
  
  if(isset($_POST['pay'])){
    $payment_amount = $_POST['payable_amount'];
    $_SESSION['payable_amount'] = $payment_amount;
    header("Location:payment.php");
  }

?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link 
      rel="stylesheet" 
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    >  

    <title>Dbms Project</title>
  </head>

  <body>
    <h4 class="p-3"><a href='trains.php'>Back</a></h4>
    <div class="container mt-5 text-center rounded p-4" style="margin:auto;background-color:#dfe7fd;position:relative">
      <h3 class="pb-5">Booking Details</h3>
      <p style="position:absolute;top:10px;right:10px" class="p-4">Train No: <br>11001</p>
      <form method="POST">
      <div class="d-flex justify-content-start px-5">
        
          <div class="d-flex flex-column align-items-start" style="width:50%">
            <div class="d-flex justify-content-between" style="width:45%">
              <p>From: <span style="font-weight:bold"><?php echo $src ?></span></p>
              <p>To: <span style="font-weight:bold"><?php echo $destn ?></span> </p>
            </div>
            <p>Date:<input readonly="readonly" class="mx-3" value="<?php echo $date ?> " style="width:7rem;background-color:#DFE7FD;outline:none;border:none;font-weight:bold"> </input></p>
            <p>Arrival Time: <span style="font-weight:bold"><?php echo $row['arrival_time'] ?></span></p>
            <p>Departure Time: <span style="font-weight:bold"><?php echo $row['dep_time'] ?></span></p>
            <p>Available Seats: <span style="font-weight:bold"><?php echo $row['available_seats'] ?></span></p>

            <div class="mt-3 p-3" style="border:1px solid black">
              <label for="num_passengers" >Number of passengers:  </label>
              <div class="d-flex align-items-center">
                <input type="number" min="1" max="5" name="num_passengers" id="num_passengers" placeholder="Enter no." class="mr-4" style="width:5.2rem" value="1"></input>
                <button class="px-4 rounded btn btn-secondary"  name="calcBtn" id="calcBtn">Calculate</button>
              </div>
            </div>
          </div>
          <div class="d-flex flex-column align-items-start" style="width:50%">
            
            <p>Price per Ticket: <input readonly="readonly" name="price_per_ticket" style="font-weight:bold;background-color:#DFE7FD;outline:none;border:none" value="<?php echo $row['price'] ?>" /></p>

            <p>No. Of Passengers: 
            <span style="font-weight:bold">
            <?php
              if(isset($_POST['calcBtn'])){
                $num_pass = $_POST['num_passengers'];
                echo $num_pass;
              }
              else{
                $num_pass = 1;
                echo $num_pass;
              }
            ?>
            </span>
            </p>
            <p >Total payable amount: INR
            <input style="font-weight:bold;background-color:#DFE7FD;outline:none;border:none" name="payable_amount" class="text-success" value="  <?php
                echo $num_pass*$row['price'];
              ?>">  
            
              </input>
            </p>
            <button type="submit" name="pay" class="bg-warning rounded p-2 text-capitalize mt-3">Proceed to Payment</button>
          </div>
        
      </div>
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