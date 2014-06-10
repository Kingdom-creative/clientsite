<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		$filmID = $_POST['filmID'];
		$filmTitle = $dbLink->real_escape_string($_POST['filmTitle']);
		$vimeoID = $dbLink->real_escape_string($_POST['vimeoID']);
		$password = $dbLink->real_escape_string($_POST['vimeoPassword']);
		
		$linkQT = $dbLink->real_escape_string($_POST['qt_file']);
		$linkWMV = $dbLink->real_escape_string($_POST['wmv_file']);
		$linkiPhone = $dbLink->real_escape_string($_POST['iphone_file']);
		$linkFLV = $dbLink->real_escape_string($_POST['flv_file']);
		$linkOther = $dbLink->real_escape_string($_POST['other_file']);
		$linkOtherLabel = $dbLink->real_escape_string($_POST['other_file_label']);
		
		$youtubeID = $dbLink->real_escape_string($_POST['youtubeID']);
		
		
	//Check if record needs to go enable YouTube stats
		
		if (empty($_POST['youtubeID'])) {
				$dbFilmUpdateQuery = sprintf(
			'UPDATE video SET 
title_VIDEO ="%s",
vimeoID_VIDEO = "%s",
password_VIDEO = "%s",
link_QT_VIDEO = "%s",
link_WMV_VIDEO = "%s",
link_iPhone_VIDEO = "%s",
link_FLV_VIDEO = "%s",
link_other_VIDEO = "%s",
link_otherLabel_VIDEO = "%s",
youtubeStats_VIDEO = NULL WHERE _kp_VIDEO = "%d"',$filmTitle,$vimeoID,$password,$linkQT,$linkWMV,$linkiPhone,$linkFLV,$linkOther,$linkOtherLabel,$filmID);
	
		} else {
			$dbFilmUpdateQuery = sprintf(
			'UPDATE video SET 
title_VIDEO ="%s",
vimeoID_VIDEO = "%s",
password_VIDEO = "%s",
link_QT_VIDEO = "%s",
link_WMV_VIDEO = "%s",
link_iPhone_VIDEO = "%s",
link_FLV_VIDEO = "%s",
link_other_VIDEO = "%s",
link_otherLabel_VIDEO = "%s",
youtubeID_VIDEO = "%s",
youtubeStats_VIDEO = 1 WHERE _kp_VIDEO = "%d"',$filmTitle,$vimeoID,$password,$linkQT,$linkWMV,$linkiPhone,$linkFLV,$linkOther,$linkOtherLabel,$youtubeID,$filmID);
		}
				
		$dbResultUpdateFilm = $dbLink->query($dbFilmUpdateQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when adding to database for film data');
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}


  $dbLink->close;

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Admin - Film Updated</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Film Updated</h2>
    
<p>Details now updated for <strong><?php echo $filmTitle; ?></strong></p>

  <p>
    <input type="button" value="Done" onClick="document.location ='http://www.circuitpro.co.uk/client/admin/home.php'" />&nbsp;&nbsp;<input type="button" value="Back" onclick="history.back()" /></p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
