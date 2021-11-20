<?php
  session_start();
      if(!isset($_SESSION['email'])) {
      echo '
        <h3>Please <a href="login.php">Login</a> to your account</h3>
      ';
      die();
  }

  include 'db.php';
  $con = createDB();
  
  $src = $_POST['src']??"";
  $destn = $_POST['destn']??"";
  $email = $_SESSION['email'];


  $sql = "SELECT * FROM train WHERE src='$src' AND destn='$destn' ";
  $result = mysqli_query($con,$sql);
  $num_of_trains = mysqli_num_rows($result);

  if(isset($_POST['searchTrains'])){
    if($num_of_trains==0){
      echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error! </strong>No trains found.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
              <span aria-hidden="true">×</span> 
          </button>
        </div> 
      ';
    }
    else{
      $_SESSION['src'] = $src;
      $_SESSION['destn'] = $destn;
      $_SESSION['num_of_trains'] = $num_of_trains;
      header("Location:trains.php");
    }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,300&family=Noto+Serif:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylesDash.css">
      

    <title>Dbms Project</title>
  </head>

  <body class="dashBody">
    <div class="img d-flex align-items-center flex-column bg-light" style = "min-height:100vh;">
      <h1 class="dash-head p-4" style="color: white; font-family: 'Noto Serif', serif;"> 
        WELCOME
        <?php echo $_SESSION["email"]; ?>
      </h1>

      <div class=" border mt-5 shadow" style="min-width:50vw; background-color: white;border-radius: 20px;opacity: 0.87;">
        <form action="" method="post" class='dashboard px-5 py-5'>

          <h4 class='d-flex justify-content-center pb-4' style="font-family: 'Noto Serif', serif;">Book A Ticket</h4>

          <div class="form-group d-flex justify-content-between"> 
            <div class="d-flex flex-column" style='width:48%'>
              <label for="src">Source Station</label> 
              <select name="src" id="src" style='height:2.5rem'>
                <option disabled selected>-- Select --</option>

                <?php
                 
                 $con = createDB();
                  $sql = "SELECT DISTINCT src FROM train";
                  $stations = mysqli_query($con,$sql);
                  
                  while($station = mysqli_fetch_array($stations))
                  {
                    $selected = $station['src'];
                    echo "<option value='$selected'>$selected</option>";
                  }
                ?>

              </select>
            </div>  

            <div class="d-flex flex-column" style='width:48%'>
              <label for="destn">Destination Station</label> 
              <select name="destn" id="destn" style='height:2.5rem'>
                <option disabled selected>-- Select --</option>
                <?php

                  $sql = "SELECT DISTINCT destn FROM train";
                  $stations = mysqli_query($con,$sql);
                  
                  while($station = mysqli_fetch_array($stations))
                  {
                    $selected = $station['destn'];
                    echo "<option value='$selected'>$selected</option>";
                  }
                ?>

              </select>
            </div>
          </div>

          <!-- <div class="form-group d-flex justify-content-between"> 
            <div class="d-flex flex-column" style='width:48%'>
              <label for="class">Class</label> 
              <select name="class" id="class" style='height:2.5rem'>
                <option disabled selected>-- Select --</option>
                <option value="General">General</option>
                <option value="AC">AC</option>
              </select>
            </div>
            <div class="d-flex flex-column" style='width:48%'>
              <label for="date">DD/MM/YY</label> 
              <input type="date" id="date" name="date"  style='height:2.5rem'>
            </div>
          </div> -->

          <div class="d-flex justify-content-between" >
            <button type="submit" class="btn btn-primary" name="searchTrains">
                Search Trains
            </button> 
          </div>
        </form> 

      </div>
    </div>

    
    <div style='position:absolute;top:2rem;right:2rem; border-bottom:1px solid grey'>
      <a href="logout.php"><h5 class='text-dark' style="color: black; background-color: #ffc107;" >Logout</h5></a>
    </div>
    <div style='position:absolute;top:2rem;right:7rem;border-bottom:1px solid grey'>
      <!-- Button trigger modal -->
      <button type="button" class="btn py-0" data-toggle="modal" data-target="#exampleModalLong">
      <h5 class='text-dark' style="color: black; background-color: #ffc107;">Your Bookings</h5>
      </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Your Tickets</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <?php

              $sql = "SELECT * FROM ticket WHERE booked_user='$email'";
              $result = mysqli_query($con,$sql);
              $count = mysqli_num_rows($result);

              if($count>0){
                while($ticket = mysqli_fetch_array($result)){
                  echo "
                    <div class='d-flex justify-content-start'>
                      <p style='width:50%'>Ticket Id: {$ticket['ticket_id']}</p>
                      <p>Train No: {$ticket['train_no']}</p>
                    </div>
                    <div class='d-flex justify-content-start border-bottom'>
                    <p style='width:50%'>No. of passengers: {$ticket['no_of_passengers']}</p>
                    <p>Booking Status: {$ticket['booking_status']}</p>
                  </div>
                  ";
                }
              }
              else{
                echo '<p>You have not booked any tickets yet!</p>';
              }
            
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
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