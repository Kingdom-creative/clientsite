<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		$project = $_POST['projectID'];
		$filmTitle = $dbLink->real_escape_string($_POST['filmTitle']);
		$projDesc = $dbLink->real_escape_string($_POST['filmDesc']);
		$lengthVideo = $_POST['duration'];
		$vimeoID = $dbLink->real_escape_string($_POST['vimeoID']);
		$password = $dbLink->real_escape_string($_POST['vimeoPassword']);
		
		$linkQT = $dbLink->real_escape_string($_POST['qt_file']);
		$linkWMV = $dbLink->real_escape_string($_POST['wmv_file']);
		$linkiPhone = $dbLink->real_escape_string($_POST['iphone_file']);
		$linkFLV = $dbLink->real_escape_string($_POST['flv_file']);
		$linkOther = $dbLink->real_escape_string($_POST['other_file']);
		$linkOtherLabel = $dbLink->real_escape_string($_POST['other_file_label']);
		
		$youtubeID = $dbLink->real_escape_string($_POST['youtubeID']);
		
		$videoBucket = $_POST['videoBucket'];
		
		
	//Check if record needs to go enable YouTube stats
		
		if (empty($_POST['youtubeID'])) {
				$dbFilmAddQuery = sprintf(
			'INSERT INTO video (
_kf_project_VIDEO,
_added_VIDEO,
title_VIDEO,
desc_VIDEO,
length_VIDEO,
vimeoID_VIDEO,
password_VIDEO,
videoBucket_VIDEO,
link_QT_VIDEO,
link_WMV_VIDEO,
link_iPhone_VIDEO,
link_FLV_VIDEO,
link_other_VIDEO,
link_otherLabel_VIDEO) VALUES
(%d,NOW(),"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s")',$project,$filmTitle,$projDesc,$lengthVideo,$vimeoID,$password,$videoBucket,$linkQT,$linkWMV,$linkiPhone,$linkFLV,$linkOther,$linkOtherLabel);
	
		} else {
			$dbFilmAddQuery = sprintf(
			'INSERT INTO video (
_kf_project_VIDEO,
_added_VIDEO,
title_VIDEO,
desc_VIDEO,
length_VIDEO,
vimeoID_VIDEO,
password_VIDEO,
videoBucket_VIDEO,
link_QT_VIDEO,
link_WMV_VIDEO,
link_iPhone_VIDEO,
link_FLV_VIDEO,
youtubeID_VIDEO,
youtubeStats_VIDEO,
link_other_VIDEO,
link_otherLabel_VIDEO) VALUES
(%d,NOW(),"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s",1,"%s","%s")',$project,$filmTitle,$projDesc,$lengthVideo,$vimeoID,$password,$videoBucket,$linkQT,$linkWMV,$linkiPhone,$linkFLV,$youtubeID,$linkOther,$linkOtherLabel);
		}		
				
		$dbResultAddFilm = $dbLink->query($dbFilmAddQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when adding to database for film data');
		
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

<title>Circuit Pro - Admin - film added</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Film Added</h2>
    
<p><strong><?php echo $filmTitle; ?></strong> added to client site.</p>
<p>&nbsp;</p>

  <p>
    <input type="button" value="Go Back" onclick="history.back()" class="cp_form_button" /></p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
