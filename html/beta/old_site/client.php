<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php

//DB Details


	define('DBHOST', '127.0.0.1');
	define('DBUSER', 'circui14_cpdb');
	define('DBPASS', 'unit4unit4');
	define('DBASE', 'circui14_client');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
      $dbClientQuery = sprintf(
			'SELECT * FROM client WHERE client_username = "%s" AND client_password = "%s"', 
			$dbLink->real_escape_string($_POST['username']),
			$dbLink->real_escape_string($_POST['password'])
		);
				
		$dbResultClient = $dbLink->query($dbClientQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for client access');
		
		//User details not found in DB	
		   if( $dbResultClient->num_rows != 1 )
			throw new Exception('Your username or password were not recognised, please try again.');
			
		
		//Get the client record out and chuck it into some session vars	
		  $clientDetail = $dbResultClient->fetch_object();
	    
	    
		$_SESSION['_client_ID'] = $clientDetail->_client_ID;
		$_SESSION['client_username'] = $clientDetail->client_username;
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}

?>

<title>Circuit Pro - Client Area PHP TITLE</title>



<style type="text/css">

<!--
body {
	font: 75%/1.5 Verdana, Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	margin: 0;
	padding: 0;
	color: #8B8B8B;
}

/* ~~ Element/tag selectors ~~ */
ul, ol, dl { /* Due to variations between browsers, it's best practices to zero padding and margin on lists. For consistency, you can either specify the amounts you want here, or on the list items (LI, DT, DD) they contain. Remember that what you do here will cascade to the .nav list unless you write a more specific selector. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
	padding-right: 15px;
	padding-left: 15px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
}
a img { /* this selector removes the default blue border displayed in some browsers around an image when it is surrounded by a link */
	border: none;
}
/* ~~ Styling for your site's links must remain in this order - including the group of selectors that create the hover effect. ~~ */
a:link {
	color: #8B8B8B;
	text-decoration: underline; /* unless you style your links to look extremely unique, it's best to provide underlines for quick visual identification */
}
a:visited {
	color: #8B8B8B;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
	text-decoration: none;
}

/* ~~ this fixed width container surrounds the other divs ~~ */
.container {
	width: 960px;
	background: #FFFFFF;
	margin: 0 auto; /* the auto value on the sides, coupled with the width, centers the layout */
}

/* ~~ the header is not given a width. It will extend the full width of your layout. It contains an image placeholder that should be replaced with your own linked logo ~~ */
.header {
	background: #FFFFFF;
}

/* ~~ This is the layout information. ~~ 

1) Padding is only placed on the top and/or bottom of the div. The elements within this div have padding on their sides. This saves you from any "box model math". Keep in mind, if you add any side padding or border to the div itself, it will be added to the width you define to create the *total* width. You may also choose to remove the padding on the element in the div and place a second div within it with no width and the padding necessary for your design.

*/

#loading {
	position:absolute;
	width:350px;
	top:400px;
	left:50%;
	height:32px;
	margin-top:-16px;
	margin-left:-150px;
	text-align:center;
	padding-top:5px;
	padding-bottom:5px;
	font:bold 12px Arial, Helvetica, sans-serif;
} 

table {
	border: 1px solid;
	border-right: none;
	border-left: none;
	border-collapse: collapse;
} 
	td {
	border:none;
	padding-top: 8px;
	padding-bottom: 8px;
	border-bottom: 1px solid;

} 

	
	.nb { border: none; } 

.content {

	padding: 8px 0;
}

.heading {
	
	color:#FFFFFF;
	background-color:#8B8B8B;
	
}

/* ~~ The footer ~~ */
.footer {
	color:#FE7A1E;
	padding: 10px 0;
	background: #FFFFFF;
}

/* ~~ miscellaneous float/clear classes ~~ */
.fltrt {  /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page. The floated element must precede the element it should be next to on the page. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class can be placed on a <br /> or empty div as the final element following the last floated div (within the #container) if the #footer is removed or taken out of the #container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
-->
</style>

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  
  
  <div class="content">
    <h2>Client Login</h2>
    
    <div align="center">
      <?php
      
      if(isset($_SESSION['_client_ID']))
     
     echo "LOGIN";
      
      ?>
    </div>

<br /><br />
</div>
  

  
  <div class="footer">
    <p>&copy; Circuit Pro 2011</p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>

<?php

	$dbResultClient->close();
	$dbLink->close();

?>
