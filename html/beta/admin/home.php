<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['admin_username'])) {


//DB Details

	include ('../db.php');
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
      $dbClientQuery = sprintf(
			'SELECT * FROM client ORDER BY name_CLIENT');
				
		$dbResultClient = $dbLink->query($dbClientQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for client data');
		
		
		//See if there are sort filters and adjust query
		
			
	$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS _kp_PROJECT, title_PROJECT, name_CLIENT, _kp_CLIENT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE live_PROJECT IS NOT NULL ORDER BY name_CLIENT, _added_PROJECT DESC';
	

		$dbResultProject = $dbLink->query($dbProjectQuery);
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
		die;
	}
	
} else {

header("Location: error_login.php");
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Admin Area / home</title>

<script type="text/javascript" src="../jquery.js"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script>  

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="loading">  
 <img src="../loader.gif" alt="loading.." />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading data, please wait.. 
</div>  

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
   
    
<table width="96%" class="content" align="center" style="border:none">
      <tr>
        <td ><a href="newProject.php" class="cp_button">Add Project</a><a href="newFilm.php" class="cp_button">Add Film</a><a href="newClient.php" class="cp_button">Add Client</a></td>
    </tr>

</table>

<p>&nbsp;</p>

<table width="96%" class="content" align="center" style="border:none">

     
	 <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td width="34%" align="left">CLIENT</td>
        <td width="27%" align="left">Username</td>
        <td width="15%" align="left">Password</td>
        <td width="24%" align="left">Server Folder</td></tr>
	 
     <?php  while( $clientDetail = $dbResultClient->fetch_object()) { ?>   
         <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="left"><strong><?php printf('<a href="editClient.php?client=%d" class="cp_client_button">%s<br />',$clientDetail->_kp_CLIENT,$clientDetail->name_CLIENT); ?></strong></td>
        <td align="left"><?php echo $clientDetail->username_CLIENT; ?></td>
        <td align="left"><?php echo $clientDetail->password_CLIENT; ?></td>
        <td align="left">/<?php printf('<a href="http://server.circuitpro.co.uk/client/admin/fileList.php?folder=%s" target="_blank">%s</a>',$clientDetail->folder_CLIENT,$clientDetail->folder_CLIENT); ?></td></tr>
<?php } ?>
</table>

<p>&nbsp;</p>




<p>&nbsp;</p>


<table width="96%" class="content" align="center" style="border:none">
<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="logout.php" method="post"><input name="download" type="submit" value="Logout" class="cp_form_button"/></form></td>
</tr>

</table>


<?php $dbLink->close(); ?>

<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>

</body>
</html>
