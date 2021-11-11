<?php

  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'db.php';
    $con = createDB();

    $email = $_POST['email'];
    $password = $_POST['upassword'];

    $email = stripcslashes($email);  
    $password = stripcslashes($password);  
    $email = mysqli_real_escape_string($con, $email);  
    $password = mysqli_real_escape_string($con, $password);  

    $sql =  "SELECT * FROM user WHERE email='$email' AND user_password='$password' ";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    $name = $row['name']??"";

    if($count == 1){  
      $_SESSION['email'] = $email;
      header("Location:dashboard.php");
    }  
    else{  
      echo ' <div class="alert alert-danger 
        alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Login failed. Invalid username or password.
        <button type="button" class="close" 
        data-dismiss="alert" aria-label="Close"> 
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

    <title>Dbms Project</title>
  </head>

  <body>

  <!-- login form -->
  <div class="border mt-5 shadow" style='max-width:80vh;margin:auto'>
    <form action="" name="login_form" onsubmit="return validation()" method="post" class='flex justify-content-center align-items-center px-5 py-5'>
      <h4 class='d-flex justify-content-center pb-4'>LOGIN</h4>

        <div class="form-group"> 
            <label for="email">Email</label> 
            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" >    
        </div>
        <div class="form-group"> 
            <label for="passw">Password</label> 
            <input type="password" class="form-control" id="upassword" name="upassword"> 
        </div>
      
      <div class="d-flex justify-content-between pt-4" style='width:100%'>
          <button type="submit" class="btn btn-primary">
              Login
          </button> 
          <a href='./../index.php'>Don't have an account? </a>
        </div>
    </form>

    <script>
      function validation(){
        var email = document.login_form.email.value;
        var password = document.login_form.upassword.value;
        if(email.length=="" || password.length==""){
          alert("Please fill in the required fields");
          return false;
        }
      }
    </script>

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