<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		$clientName = $dbLink->real_escape_string($_POST['clientName']);
		$clientUsername = $dbLink->real_escape_string($_POST['clientUsername']);
		$clientPassword = $dbLink->real_escape_string($_POST['clientPassword']);
		$clientFolder = $dbLink->real_escape_string($_POST['clientFolder']);
		
		
	
			$dbClientAddQuery = sprintf(
			'INSERT INTO client (name_CLIENT,username_CLIENT,password_CLIENT,folder_CLIENT) VALUES ("%s","%s","%s","%s")',$clientName,$clientUsername,$clientPassword,$clientFolder);
		
				
		$dbResultAddClient = $dbLink->query($dbClientAddQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when adding to database for client data');
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Admin - Client Added</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Client Added</h2>
    
<p><strong><?php echo $clientName; ?></strong> added to client site.</p>

<p><span class="cp_form_button"><strong>!! Please ensure the "<?php echo $clientFolder; ?>" folder is created on the server !!</strong></span></p>

  <p>
   <input type="button" value="Back" onClick="document.location ='http://www.circuitpro.co.uk/client/admin/home.php'" class="cp_form_button"/>&nbsp;&nbsp;</p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
