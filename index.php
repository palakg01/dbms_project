<?php

  session_start();
  $exists= false;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include './pages/db.php';
    $con = createDB();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['passw'];
    $cpassword = $_POST['cpassw'];
    $phone = $_POST['phone'];

    $sql = "SELECT * FROM user where email='$email'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);

    if(isset($_SESSION['payable_amount'])){
      unset($_SESSION['payanle_amount']);
    }

    if($num == 0){
      if(($password == $cpassword) && $exists == false){

        $hash = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name,email,user_password,phone) VALUES ('$name','$email','$password','$phone')";

        $result = mysqli_query($con, $sql);

        if(!$name || !$email || !$phone){
          echo ' 
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>Fill in the required fields.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button>
          </div> 
        '; 
        }

        else{
          if($result){
            echo "
              <script>
                alert('Account has been created!');
                window.location.href='./pages/login.php';
              </script>
            ";
          }
        }
      }

      else{
        echo ' 
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>Passwords do not match.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </button>
          </div> 
        '; 
      }
    }

    if($num>0){
      echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error! </strong> Account already exists. Please login.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
              <span aria-hidden="true">×</span> 
          </button>
        </div> 
      '; 
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
    <link rel="stylesheet"  href="style.css">
    <title>Dbms Project</title>

    
  </head>

  <body>

  <!-- signup form -->

    <div class="border mt-4 mb-3 shadow index-form" style='max-width:80vh;margin:auto;'>
      <form action="" method="post" class='flex justify-content-center align-items-center px-5 py-5'>

        <h4 class='d-flex justify-content-center pb-4 index-heading' style="font-family: 'Noto Serif', serif;">Register</h4>
        <div class="form-group"> 
            <label for="username">Name <span style='color:red'>*</span></label> 
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">    
        </div>

        <div class="form-group"> 
            <label for="email">Email <span style='color:red'>*</span></label> 
            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" >    
        </div>

        <div class="form-group"> 
            <label for="passw">Password <span style='color:red'>*</span></label> 
            <input type="password" class="form-control" id="passw" name="passw"> 
        </div>

        <div class="form-group"> 
            <label for="cpassw">Confirm Password <span style='color:red'>*</span></label> 
            <input type="password" class="form-control" id="cpassw" name="cpassw">
        </div>    
        
        <div class="form-group"> 
            <label for="phone">Contact No. <span style='color:red'>*</span></label> 
            <input type="number" class="form-control" id="phone" name="phone">
        </div>    

        <div class="d-flex justify-content-between" style='width:100%;'>
          <button type="submit" class="btn btn-primary">
              Sign up
          </button> 
          <a href='./pages/login.php'>Already have an account? </a>
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