<?php 



ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['username'])) {


//DB Details

	include ('../db.php');
	
	$viewsCount = 0;
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
      $dbClientQuery = sprintf(
			'SELECT * FROM client WHERE username_CLIENT = "%s" AND password_CLIENT = "%s"', 
			($_SESSION['username']),
			($_SESSION['password'])
		);
				
		$dbResultClient = $dbLink->query($dbClientQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for client access');
		
		//User details not found in DB	
		   if( $dbResultClient->num_rows != 1 )
			throw new Exception('Session login details not recognised, please return to the login page to login again.');
			
		
		//Get the client record out into object	
		$clientDetail = $dbResultClient->fetch_object();
	
	      }
      	catch(Exception $thisException)
	{
		include('../error.php');
	}
	
} else {

header("Location: ../error_login.php");
	
}
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Area / <?php echo $clientDetail->name_CLIENT; ?> / project stats</title>

<script type="text/javascript" src="../jquery.js"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script>  

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>



<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a>
  
     <div id="loading">  
 <img src="../loader.gif" alt="loading.." />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Updating data... 
</div>  

<div id="youtube_logo">  
</div> 
  
    <!-- end .header --></div>
    

  <div class="content">
    <h2><a href="../home.php">Client Area / <?php echo $clientDetail->name_CLIENT; ?></a> / project stats</h2>
    
    
<table width="96%" class="heading" align="center">
          <tr>
        <td align="right" bgcolor="#FFFFFF"><strong><a href="index.php">View All</a></strong></td>
      </tr>
    </table>

    <p>&nbsp;</p>
    <table width="96%" class="content" align="center">
      <tr>
        <td width="53%"><strong>Project</strong></td>
    <td width="14%" align="left"><strong>
     <?php if($_GET["sort"] == "views") { ?>Views<?php } else { ?><a href="breakdown.php?sort=views">Views</a><?php } ?></strong>
    </td>
 
 
<?php
	

	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
	$dbCountLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		if($_GET["sort"] == "views") {
			
	$dbProjectQuery = 'SELECT _kp_PROJECT, title_PROJECT, youtubeViews_PROJECT from project WHERE _kf_client_PROJECT = '.$clientDetail->_kp_CLIENT.' AND youtubeStats_PROJECT IS NOT NULL ORDER BY youtubeViews_PROJECT DESC';
	
		} else {
	$dbProjectQuery = 'SELECT _kp_PROJECT, title_PROJECT, youtubeViews_PROJECT from project WHERE _kf_client_PROJECT = '.$clientDetail->_kp_CLIENT.' AND youtubeStats_PROJECT IS NOT NULL ORDER BY _added_PROJECT DESC';
		}
		
		$dbResult = $dbLink->query($dbProjectQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for projects (A)');
			
			$tabIndex = 0;


	while( $projectData = $dbResult->fetch_object()) {
		
		
	$dbCountQuery = 'SELECT SUM(youtubeViews_VIDEO) AS viewsTotal_PROJECT from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'"';
	
	$dbCountResult = $dbLink->query($dbCountQuery);
	$dbCountData = $dbCountResult->fetch_object();
	
	$dbUpdateQuery = 'UPDATE project SET youtubeViews_PROJECT ="'.$dbCountData->viewsTotal_PROJECT.'" WHERE _kp_PROJECT ="'.$projectData->_kp_PROJECT.'"';
	
	
	 $dbCountUpdateResult = $dbLink->query($dbUpdateQuery);
		
			//Write out the rows to display
	  	//	echo '<tr><td>'. $projectData->title_PROJECT . '</td>';
		
		$divID = str_replace(' ', '', $projectData->title_PROJECT);
	
	printf('<tr><td>
      <div id="%s" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="%d">%s</div>
          <div class="CollapsiblePanelContent">',$divID,$tabIndex,$projectData->title_PROJECT); 

	
	//Get individual video items for each project
	$dbVideoQuery = 'SELECT _kp_VIDEO, youtubeTitle_VIDEO, youtubeID_VIDEO, youtubeViews_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'" AND youtubeID_VIDEO IS NOT NULL ORDER BY youtubeViews_VIDEO DESC';
	$dbVideoResult = $dbLink->query($dbVideoQuery);
	
	//cycle through them
	while ($videoData = $dbVideoResult->fetch_object()) {
		
		printf('<a href="http://www.youtube.com/watch?v=%s">%s</a> (%s)<br />',$videoData->youtubeID_VIDEO,$videoData->youtubeTitle_VIDEO,number_format($videoData->youtubeViews_VIDEO));
		
		}
			
	  	  	echo '</div>
          </div>
        </td><td>'. number_format($dbCountData->viewsTotal_PROJECT) . '</td></tr>';
		
		//Create Variable for Each Panel
		printf('<script type="text/javascript">
var CollapsiblePanel%d = new Spry.Widget.CollapsiblePanel("%s", {contentIsOpen:false});
</script>',$tabIndex,$divID);

$tabIndex = $tabIndex + 1;

	}
	
	$dbCountResult->close();
	$dbResultClient->close();
	$dbResult->close();
	$dbLink->close();

?>

</table>



<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 2011</p>
  </div>
</div>
</body>
</html>
