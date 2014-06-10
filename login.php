<?php

session_start();

include ('db.php');
include ('functions.php');
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
      $dbClientQuery = sprintf(
			'SELECT * FROM client WHERE username_CLIENT = "%s" AND password_CLIENT = "%s"', 
			$dbLink->real_escape_string($_POST['username']),
			$dbLink->real_escape_string($_POST['password'])
		);
				
		$dbResultClient = $dbLink->query($dbClientQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for client access');
		
		//User details not found in DB	
		   if( $dbResultClient->num_rows != 1 )
			throw new Exception('Your username or password were not recognised :(');
			
		
		//Get the client record out and chuck it into some session vars	
		  $clientDetail = $dbResultClient->fetch_object();
		  
		  
		 	 //Create a session cookie if requested
		if (isset($_POST['remember'])) {
	
		setcookie('client-ID', $clientDetail->_kp_CLIENT, time() + (86400 * 60)); } else {
	    
		$_SESSION['_ID'] = $clientDetail->_kp_CLIENT;
		$_SESSION['username'] = $clientDetail->username_CLIENT;
        $_SESSION['password'] = $clientDetail->password_CLIENT;
        
        } 
		 
	    
		
                
        $dbResultClient->close();
		$dbLink->close();
		
		//Note the login time for client
		
		clientLoginTimeStamp($_SESSION['_ID']);  
		
			if (isset($_SESSION['returnPage'])) {
		
		header("Location: ".$_SESSION['returnPage']);
		
		} else {
	
		header("Location: ".$clientDetail->username_CLIENT. "/home"); }
	
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
		die;
	}
        
        

?>
