<?php

    // This code takes phone number & OTP as an input via GET http request and checks if OTP is correct for the given number and also gives proper messages if the provided OTP is expired.
    
    include 'config/DatabaseConfiguration.php';
    
    $con = mysqli_connect($host,$username,$password,$database);
    $con2 = mysqli_connect($host,$username,$password,$database);
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $user_id = $obj['user_id'];
    $user_mobile = $obj['user_mobile'];
    $otp_entered = $obj['otp_entered'];
    
    
    
    $otpValidateQuery = "SELECT * FROM `mobile_otp_verification` WHERE `user_id` = '$user_id' AND `user_mobile` = '$user_mobile' AND `otp` = '$otp_entered'";
    
    $check = mysqli_fetch_array(mysqli_query($con,$otpValidateQuery));
    
    
    if(isset($check)){
        
        $updateMobileQuery = "UPDATE users SET user_phone = $user_mobile, isPhoneVerified= 1 WHERE user_id = $user_id;";
        
        
        $check2 = mysqli_fetch_array(mysqli_query($con2,$updateMobileQuery));
        
        if($con2->query($updateMobileQuery) === TRUE){
            $msg = "OTP correct and mobile number verified successfully";

            $jsonstring = json_encode($msg);
            echo $jsonstring;
        
        }
        
        else{
	    
		    $InvalidMSG = 'Cannot Update your phone! Please try again later.';
		    $InvalidMSGJSon = json_encode($InvalidMSG);
		    echo $InvalidMSGJSon ;
	 
	 }
       
	 
	 }
	 
	 else{
	    
		$InvalidMSG = 'Invalid OTP';
		$InvalidMSGJSon = json_encode($InvalidMSG);
		 echo $InvalidMSGJSon ;
	 
	 }
 
 mysqli_close($con);
?>