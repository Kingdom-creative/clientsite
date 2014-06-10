<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		$client = $_POST['clientID'];
		$added = $_POST['added'];
		$projTitle = $dbLink->real_escape_string($_POST['projTitle']);
		$projCheck1 = $dbLink->real_escape_string($_POST['check1']);
		$projCheck2 = $dbLink->real_escape_string($_POST['check2']);
		$projCheck3 = $dbLink->real_escape_string($_POST['check3']);
		$projCheck4 = $dbLink->real_escape_string($_POST['check4']);
		$projCheck5 = $dbLink->real_escape_string($_POST['check5']);
		
		$date_firstDelivery = $_POST['date_firstDelivery'];
		$date_approval = $_POST['date_approval'];
		$date_finalDelivery = $_POST['date_finalDelivery'];
		
		$prodMgr = $_POST['prodMgr'];
		$creativeMgr = $_POST['creativeMgr'];
		$editor = $_POST['editor'];
		
		$notes_ext = $dbLink->real_escape_string($_POST['notes_ext']);
		$notes_int = $dbLink->real_escape_string($_POST['notes_int']);

		
	//Check if project record needs to go live first up	
		if ($_POST['live'] == "live") {
		
		$dbProjectAddQuery = sprintf(
			'INSERT INTO project (_kf_client_PROJECT,_added_PROJECT,title_PROJECT,live_PROJECT,check1_achieve_PROJECT,check2_platform_PROJECT,check3_format_PROJECT,check4_duration_PROJECT,check5_graphics_PROJECT,date_firstDelivery_PROJECT,date_approval_PROJECT,date_finalDelivery_PROJECT,_kf_staff_prodManager_PROJECT,_kf_staff_creativeManager_PROJECT,_kf_staff_editor_PROJECT,status_PROJECT,notes_ext_PROJECT,notes_int_PROJECT) VALUES (%d,"%s","%s",1,"%s","%s","%s","%s","%s","%s","%s","%s",%d,%d,%d,"Active","%s","%s")',$client,$added,$projTitle,$projCheck1,$projCheck2,$projCheck3,$projCheck4,$projCheck5,$date_firstDelivery,$date_approval,$date_finalDelivery,$prodMgr,$creativeMgr,$editor,$notes_ext,$notes_int);
	
		} else {
			$dbProjectAddQuery = sprintf(
			'INSERT INTO project (_kf_client_PROJECT,_added_PROJECT,title_PROJECT,check1_achieve_PROJECT,check2_platform_PROJECT,check3_format_PROJECT,check4_duration_PROJECT,check5_graphics_PROJECT,date_firstDelivery_PROJECT,date_approval_PROJECT,date_finalDelivery_PROJECT,_kf_staff_prodManager_PROJECT,_kf_staff_creativeManager_PROJECT,_kf_staff_editor_PROJECT,status_PROJECT,notes_ext_PROJECT,notes_int_PROJECT) VALUES (%d,"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",%d,%d,%d,"Active","%s","%s")',$client,$added,$projTitle,$projCheck1,$projCheck2,$projCheck3,$projCheck4,$projCheck5,$date_firstDelivery,$date_approval,$date_finalDelivery,$prodMgr,$creativeMgr,$editor,$notes_ext,$notes_int);
		}		
				
		$dbResultAddProject = $dbLink->query($dbProjectAddQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when adding to database for project data');
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}
	
	
	$mailMessage = sprintf('<html>
		<body align="left" style="font-family:Arial, Helvetica, sans-serif;width:970px;">
        <img src="http://circuitpro.co.uk/client/images/cp_logo.jpg" width="277" height="71">
        <hr>
		<h3 style="font-family:Arial, Helvetica, sans-serif;color:#cc6600">"%s" added to client site</h3>
		<hr>
		<table width="400" border="0">
  <tr>
  	<td>Project:</td>
  	<td>%s</td>
  	</tr>
   <tr>
    <td>Date of First Delivery:</td>
    <td>%s</td>
  </tr>
  <tr>
    <td>Date of Client Approval:</td>
    <td>%s</td>
  </tr>
  <tr>
    <td>Date of Final Delivery:</td>
    <td>%s</td>
  </tr>
    <tr>
    <td>Internal Notes:</td>
    <td>%s</td>
  </tr>
</table>
		<p>To view or edit:</p>
		<p><strong><a href="http://circuitpro.co.uk/client/admin/" style="font-family:Arial, Helvetica, sans-serif;color:#cc6600;">CLICK HERE TO SIGN IN</a></strong></p>
		<p>&nbsp;</p>
		<hr>
		</body>
</html>',$projTitle,$projTitle,date('jS F Y', strtotime($date_firstDelivery)),date('jS F Y', strtotime($date_approval)),date('jS F Y', strtotime($date_finalDelivery)),$notes_int);

	$subject = sprintf('Client Site - New Project: %s',$projTitle);
	
	
		$headers = 'From: '.SITE_SUPPORT_EMAIL.'' . "\r\n" .
	   'MIME-Version: 1.0' . "\r\n" .
	   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
	   'Reply-To: '. SITE_SUPPORT_EMAIL .'' . "\r\n" .
	   'Return-Path: '.SITE_SUPPORT_EMAIL.'' . "\r\n" .
	   'X-Mailer: PHP/' . phpversion();
	ini_set('sendmail_from', SITE_SUPPORT_EMAIL);
	
	mail("simon.harrison@circuitpro.co.uk, charlotte.randall@circuitpro.co.uk, hannah.cook@circuitpro.co.uk, ben.treston@circuitpro.co.uk", $subject, $mailMessage, $headers);
	


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Admin - Project Added</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Project Added</h2>
    
<p><strong><?php echo $projTitle; ?></strong> added to client site.</p>

  <p>
   <input type="button" value="Back" onClick="document.location ='http://www.circuitpro.co.uk/client/admin/newProject.php'" class="cp_form_button"/>&nbsp;&nbsp;</p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
