<?php
    include 'config/DatabaseConfiguration.php';
    

    $con = mysqli_connect($host,$username,$password,$database);
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $phone = $obj['phone'];
    $user_id = $obj['user_id'];
    $otp = rand(100000,999999);
    date_default_timezone_set("Asia/Calcutta");
    $DateTime = date("Y-m-d H:i:s");
    

    
    

    
    
    $Sql_Query = "INSERT INTO `mobile_otp_verification` (`user_id`, `user_mobile`, `otp`,`date_time_of_generation`) VALUES ('$user_id', '$phone', '$otp', '$DateTime');";
	 
	 
	    if(mysqli_query($con,$Sql_Query)){
	        
	        
	        
	       
	        
		    $MSG = 'OTP successfully added to database';
		    
		    $json = json_encode($MSG);
		    
		    //Sending OTP//////////////////////////
		    $sender ='XXXXXX';
            $mob = $phone;
            $auth='XXXXXXX';
            $msg = urlencode("XXXXXXXXXXXX"); 
            

            $url = 'XXXXXXXX';  // API URL
            
            
            

            //function define
            function SendSMS($hostUrl){
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $hostUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                $result = curl_exec($ch);
                return $result;
            } 
            //
            $result=SendSMS($url);  // call function that return response with code
            
            echo $result;
		    ////////////////////////////////////////
		    
	    }
	  else{
		    echo 'Try Again';
	 }
 
 mysqli_close($con);
    
    

?>