<?php

include ('../db.php');

      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		
		$projectID = $_POST['projectID'];
		$client = $_POST['clientID'];
		$liveProject = $_POST['live'];
		$youTubeStatsProject = $_POST['youtubeStats'];

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
		
		if(isset($_POST['completed'])) { $status = "Completed"; 
		
		
		//Query to update project
		
	$dbProjectUpdateQuery = sprintf(
			'UPDATE project SET 
			title_PROJECT = "%s",
			live_PROJECT = "%d",
			check1_achieve_PROJECT = "%s",
			check2_platform_PROJECT = "%s",
			check3_format_PROJECT = "%s",
			check4_duration_PROJECT = "%s",
			check5_graphics_PROJECT = "%s",
			date_firstDelivery_PROJECT = "%s",
			date_approval_PROJECT = "%s",
			date_finalDelivery_PROJECT = "%s",
			_kf_staff_prodManager_PROJECT = "%d",
			_kf_staff_creativeManager_PROJECT = "%d",
			_kf_staff_editor_PROJECT = "%d",
			notes_ext_PROJECT = "%s",
			notes_int_PROJECT = "%s",
			youtubeStats_PROJECT = "%d",
			status_PROJECT = "%s",
			_completed_PROJECT = DATE(NOW())  
			WHERE _kp_PROJECT = "%d"',
			
			$projTitle,
			$liveProject,
			$projCheck1,
			$projCheck2,
			$projCheck3,
			$projCheck4,
			$projCheck5,
			$date_firstDelivery,
			$date_approval,
			$date_finalDelivery,
			$prodMgr,
			$creativeMgr,
			$editor,
			$notes_ext,
			$notes_int,
			$youTubeStatsProject,
			$status,
			$projectID
	);
		
		
		} else { $status = "Active";
		
		//Query to update project
		
	$dbProjectUpdateQuery = sprintf(
			'UPDATE project SET 
			title_PROJECT = "%s",
			live_PROJECT = "%d",
			check1_achieve_PROJECT = "%s",
			check2_platform_PROJECT = "%s",
			check3_format_PROJECT = "%s",
			check4_duration_PROJECT = "%s",
			check5_graphics_PROJECT = "%s",
			date_firstDelivery_PROJECT = "%s",
			date_approval_PROJECT = "%s",
			date_finalDelivery_PROJECT = "%s",
			_kf_staff_prodManager_PROJECT = "%d",
			_kf_staff_creativeManager_PROJECT = "%d",
			_kf_staff_editor_PROJECT = "%d",
			notes_ext_PROJECT = "%s",
			notes_int_PROJECT = "%s",
			youtubeStats_PROJECT = "%d" 
			WHERE _kp_PROJECT = "%d"',
			
			$projTitle,
			$liveProject,
			$projCheck1,
			$projCheck2,
			$projCheck3,
			$projCheck4,
			$projCheck5,
			$date_firstDelivery,
			$date_approval,
			$date_finalDelivery,
			$prodMgr,
			$creativeMgr,
			$editor,
			$notes_ext,
			$notes_int,
			$youTubeStatsProject,
			$projectID
	);
		
		
		
		 }	
		
	
	
				
		$dbResultUpdateProject = $dbLink->query($dbProjectUpdateQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when adding to database for project data');
		
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

<title>Circuit Pro - Admin - Project Updated</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Project Details Updated</h2>
    
<p>Details now updated for <strong><?php echo $projTitle; ?></strong></p>

  <p>
    <input type="button" value="OK" onClick="document.location ='http://www.circuitpro.co.uk/client/admin/home.php'" />&nbsp;&nbsp;<input type="button" value="Cancel" onclick="history.back()" /></p>
           

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
