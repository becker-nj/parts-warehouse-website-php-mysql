<?php

    $user='id3367215_admin';
    $pass='group1';
    $db = 'id3367215_partswarehouse';
    //$con = new mysqli('localhost', $user, $pass, $db) or die ("Unable to connect");

    $con = mysqli_connect('localhost',$user,$pass,$db);

    if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
    }   
    
    //$con = mysqli_connect('127.0.0.1','root','');
    if(!$con)
    {
        echo 'Not Connected To Server';
    }
    if (!mysqli_select_db ($con,$db))
    {
        echo 'Database Not Selected';
    }
    

	$binNum = $_POST['binNum'];
	$quantity = $_POST['quantity'];
	
	$checkExists = "SELECT 1 FROM partBin WHERE binNum='$binNum'";
	$binExistence = mysqli_query($con,$checkExists);
	

	

    if(isset($_POST['radio']))
	{
		$choice = $_POST['radio'];
	}

	
	
	if($quantity > 0)
	{
		if($binExistence->num_rows > 0)
		{
			$currBinQuanRes = mysqli_query($con,"SELECT quantity FROM partBin WHERE binNum='$binNum'");
			$currBinQuan = $currBinQuanRes->fetch_object()->quantity;
				
			if($choice == 'decrease')
			{
			  $finalQuan = $currBinQuan - $quantity;
			  mysqli_query($con,"UPDATE partBin SET quantity='$finalQuan' WHERE binNum = '$binNum'");
			}
			
			else
			{
			  $finalQuan = $currBinQuan + $quantity;
			  mysqli_query($con,"UPDATE partBin SET quantity='$finalQuan' WHERE binNum = '$binNum'");
			}
			
			$currBinQuanRes = mysqli_query($con,"SELECT quantity FROM partBin WHERE binNum='$binNum'");
			$currBinQuan = $currBinQuanRes->fetch_object()->quantity;
			echo "The new bin quantity is: '$currBinQuan'";
		}
		else
		{
			echo "Bin doesn't exist";
		}
	}
	else
	{
		echo "Try with a positive quantity";
	}

    $con->close();
?>﻿