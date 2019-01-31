<?php
    error_reporting(E_ALL);
    session_start();
    session_regenerate_id();

    $user="id3367215_admin";
    $pass="group1";
    $db="id3367215_partswarehouse";
    $con = mysqli_connect("localhost",$user,$pass,$db);

    if (!$con) 
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }   
    

	$orderNum = $_POST['orderNum'];

	
    $deleteOrder = "DELETE FROM orders WHERE orderNum='$orderNum'";
	
	$checkExists = "SELECT 1 FROM orders WHERE orderNum='$orderNum'";
	$orderExistence = mysqli_query($con,$checkExists);
	
		
	if($orderExistence->num_rows > 0)
	{
		$orderPartNumRes = mysqli_query($con,"SELECT partNo FROM orders WHERE orderNum='$orderNum'");
		$orderPartNum = $orderPartNumRes->fetch_object()->partNo;
		
		$orderPartQuanRes = mysqli_query($con,"SELECT quantity FROM orders WHERE orderNum='$orderNum'");
		$orderPartQuan = $orderPartQuanRes->fetch_object()->quantity;
		
		$partBinToUpdateRes = mysqli_query($con,"SELECT binNum FROM partBin WHERE partNo='$orderPartNum'");
		$partBinToUpdate = $partBinToUpdateRes->fetch_object()->binNum;
		
		$currPartBinQuanRes = mysqli_query($con,"SELECT quantity FROM partBin WHERE binNum='$partBinToUpdate'");
		$currPartBinQuan = $currPartBinQuanRes->fetch_object()->quantity;
		
		$finalQuan = $orderPartQuan + $currPartBinQuan;
		
	    $updatePartBinQuan = mysqli_query($con,"UPDATE partBin SET quantity='$finalQuan' WHERE binNum = '$partBinToUpdate'");
		
		mysqli_query($con,$deleteOrder);
		
		echo "Order deleted and partbin quantities updated.";
	}
	else
	{
		echo "Order doesn't exist";
	}
	
	$con->close();

?>﻿