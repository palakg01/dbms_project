<?php
  session_start();

  include 'db.php';
  $con = createDB();

  $src = $_SESSION['src'];
  $destn = $_SESSION['destn'];
  $num_of_trains = $_SESSION['num_of_trains'];

  if(isset($_POST['bookBtn'])){

    $train_no = $_POST['train_no'];
    $date = $_POST['date'];
    $_SESSION['train_no'] = $train_no;
    $_SESSION['date'] = $date;
    header("Location:booking.php");
  }

  if(isset($_SESSION['payable_amount'])){
    unset($_SESSION['payanle_amount']);
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
    <div class="d-flex flex-column">
      <a href="dashboard.php" style="position:absolute;top:15px; left:15px;color:white;font-size:1.3rem">Back</a>
      <h4 class="bg-info p-3 text-center"><?php echo $num_of_trains ?> Results found for <?php echo $src ?> -> <?php echo $destn ?></h4>

      <div class="d-flex flex-column align-items-center pt-5 mx-5 px-5">
        
            <?php
            
            $sql = "SELECT * FROM train WHERE src='$src' and destn='$destn'";
            $result =  mysqli_query($GLOBALS['con'],$sql);
            $date1 = date('Y-m-d');
            $date = strtotime("+7 day");
            $date2 = date('Y-m-d',$date);
            
            if($result){
              while($row=mysqli_fetch_assoc($result))
              {
                echo '
                <div class="container mx-5 px-5 border my-3 p-4 rounded" style="width:50%;background-color:#D3DCE3">
                 
                  <h5 class="px-2 pt-1 text-capitalize position-absolute text-info">'.$row['train_name'].'</h5>
                  <div class="d-flex mb-3 justify-content-center p-0 text-success text-capitalize">
                    <h4>'.$row['src'].'</h4>
                    <h4> &nbsp;&nbsp;&nbsp;&nbsp;to&nbsp;&nbsp;&nbsp;&nbsp; </h4>
                    <h4>'.$row['destn'].'</h4>
                  </div>

                  <form action="" method="POST">
                    <div class="d-flex justify-content-between align-items-center ">
                      <div class="d-flex flex-column">
                        <h6 class="px-2 rounded">Price: $'.$row['price'].'</h6>
                        <h6 class="px-2 rounded">Time: '.$row['arrival_time'].'</h6>
                        <input class="mt-2 px-2 mx-2" type="date" id="date" name="date" value='.$date1.' min='.$date1.' max='.$date2.'>
                      </div>

                      <div class="d-flex flex-column m-2 justify-content-between px-2">
                        <div class="form-group d-flex flex-column">
                          <div class="d-flex align-items-center">
                            <label for="train_no">Train no: &nbsp;</label>
                            <input class="px-2 my-2" type="text" id="train_no" name="train_no" readonly="readonly" value="'.$row['train_no'].'" style="width:5rem">
                          </div>
                          <button type="submit" name="bookBtn" class="py-1 mt-2 px-4 shadow bg-warning rounded">
                            Book Now
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>

                </div>
                ';
              }
            }
           
            ?>
       
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