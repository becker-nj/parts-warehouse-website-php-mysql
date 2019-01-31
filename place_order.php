<?php
    error_reporting(E_ALL);
    session_start();
    session_regenerate_id();
    date_default_timezone_set("America/Chicago");

    $user="id3367215_admin";
    $pass="group1";
    $db="id3367215_partswarehouse";
    $con = mysqli_connect("localhost",$user,$pass,$db);

    if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
    }   
    
	$partID = $_POST['partID'];
	$quantity = $_POST['quantity'];
	$phoneNum = $_POST['phoneNum'];
	
	$checkPartExists = "SELECT 1 FROM parts WHERE partID='$partID'";
	$partExistence = mysqli_query($con,$checkPartExists);
	
	$checkPhoneExists = "SELECT 1 FROM factoryInvManager WHERE phoneNo='$phoneNum'";
	$phoneExistence = mysqli_query($con,$checkPhoneExists);
	
	$currDate = date("Y-m-d");
	
	if($partExistence->num_rows > 0 && $quantity > 0  && $phoneExistence->num_rows > 0)
	{
        mysqli_query($con,
           "INSERT INTO orders (partNo, quantity, status, orderDate, custPhoneNum)
            VALUES($partID, $quantity, 'n', '$currDate', $phoneNum)");


        echo "Order placed.";
	}
	else if($partExistence->num_rows == 0)
	{
		echo "Part Number Doesn't Exist";
	}
	
	else if($quantity <= 0)
	{
	  echo "Please try a positive quantity.";   
	}
	
	else if($phoneExistence->num_rows == 0)
	{
	    echo "Phone Number Doesn't Exist. Use 10 digits ex.(1234567890)";    
	}
	
	
	$con->close();

?>﻿