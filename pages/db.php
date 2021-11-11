<?php

function createDB(){
  $hostname = "localhost";
  $username = 'root';
  $password = '';
  $dbname = 'railway_system';

  $con = mysqli_connect($hostname,$username,$password);

  if(!$con){
    die("Connection failed: ".mysqli_connect_error());
  }

  $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

  if(mysqli_query($con,$sql)){
    $con = mysqli_connect($hostname,$username,$password,$dbname);

    $sql = "  
      CREATE TABLE IF NOT EXISTS user(
        email VARCHAR(25) NOT NULL PRIMARY KEY,
        uname VARCHAR(25) NOT NULL,
        upass VARCHAR(25) NOT NULL,
        uphone VARCHAR(10) NOT NULL
      ); 
    ";

    if(mysqli_query($con,$sql)){
      return $con;
    }
    else{
      echo "Errorin creating table";
    }
  }
}

?>