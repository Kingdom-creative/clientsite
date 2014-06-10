<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		$projectID = $_GET['project'];
	
		$dbProjectDeleteQuery = sprintf('DELETE FROM project WHERE _kp_PROJECT = "%d"',$projectID);
	
				
		$dbResultDeleteProject = $dbLink->query($dbProjectDeleteQuery);
		
		$deleted = mysqli_affected_rows($dbLink);
		
		
		if(!$deleted) {
		
		throw new Exception('Error removing project record - does not exist');
			
		}
		
		
		
		$dbLink->close();
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when removing project from database');
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
		die;
	}


  $dbLink->close;

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Admin - Project Deleted</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Project Deleted</h2>
    
<p>Project has now been deleted from client site.</p>

  <p>
    <input type="button" value="OK" onClick="document.location ='http://www.circuitpro.co.uk/client/admin/home.php'" />&nbsp;&nbsp;</p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 2012</p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
