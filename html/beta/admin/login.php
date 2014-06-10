<?php

session_start();

include ('../db.php');
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
      $dbUserQuery = sprintf(
			'SELECT * FROM user WHERE username_USER = "%s" AND password_USER = "%s"', 
			$dbLink->real_escape_string($_POST['username']),
			$dbLink->real_escape_string($_POST['password'])
		);
				
		$dbUserResult = $dbLink->query($dbUserQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for admin access');
		
		//User details not found in DB	
		   if( $dbUserResult->num_rows != 1 )
			throw new Exception('Your username or password were not recognised, please try again.');
			
		
		//Get the client record out and chuck it into some session vars	
		  $userDetail = $dbUserResult->fetch_object();
	    
				$_SESSION['_ID'] = $userDetail->_kp_USER;
				$_SESSION['admin_username'] = $userDetail->username_USER;
                $_SESSION['admin_password'] = $userDetail->password_USER;
				$_SESSION['admin_level'] = $userDetail->admin_USER;
                
                $dbUserResult->close();
		$dbLink->close();
	
		header("Location: home.php");
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}
        
        

?>