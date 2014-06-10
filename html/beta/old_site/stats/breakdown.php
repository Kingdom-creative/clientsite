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

<link href="../clientside.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryCollapsiblePanel2.css" rel="stylesheet" type="text/css" />
</head>

<body>



<div id="container">
  <div id="header">
    <div id="loading">Getting data...</div>
    <ul id="headernav">
    
      <li><form action="../logout.php" method="post">
        <input name="download" type="submit" value="Logout" />
      </form></li>
      <li><a href="../<?php echo $_SESSION['username']; ?>/home">Home</a>&nbsp;&nbsp;/&nbsp;&nbsp;</li>
    </ul>
    <div id="headertag"><span class="orange">CLIENT AREA_</span><?php $client = $clientDetail->name_CLIENT; $client=ucfirst(strtolower($client)); echo $client;?>
    
    <div class="floatRight">view by&nbsp;<a class="button" href="index.php">LIST</a><a class="button<?php if($_GET["sort"] == "views") { echo ' selected';}?>" href="breakdown.php?sort=views">VIEWS</a><a class="button<?php if(!$_GET["sort"] == "views") { echo ' selected';}?>" href="breakdown.php">DATE</a></div></div>
  </div>
    

  <div class="content">
    

    <table width="90%" align="center">
      <tr>
        <td class="table-head">Project
          <div class="floatRight">Views</div></td>
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
		
		$divID = str_replace(' ', '', $projectData->title_PROJECT);?>
	
	<tr><td>
      <div id="<?php echo $divID;?>" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="<?php echo $tabIndex;?>"><?php echo $projectData->title_PROJECT;?><span class="floatRight"> <?php echo number_format($dbCountData->viewsTotal_PROJECT); ?></span></div>
          <div class="CollapsiblePanelContent">

	<?php
	//Get individual video items for each project
	$dbVideoQuery = 'SELECT _kp_VIDEO, youtubeTitle_VIDEO, youtubeID_VIDEO, youtubeViews_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'" AND youtubeID_VIDEO IS NOT NULL ORDER BY youtubeViews_VIDEO DESC';
	$dbVideoResult = $dbLink->query($dbVideoQuery);
	
	//cycle through them
	while ($videoData = $dbVideoResult->fetch_object()) {?>
		
		<div class="filmlink"><a href="http://www.youtube.com/watch?v=<?php echo $videoData->youtubeID_VIDEO; ?>"><?php echo $videoData->youtubeTitle_VIDEO;?></a> <span class="floatRight">(<?php echo number_format($videoData->youtubeViews_VIDEO);?>)</span></div>
		
		<?php  } ?>
			
	  	  	</div>
        </div>       </td></tr>
		
		
		<script type="text/javascript">
var CollapsiblePanel<?php echo $tabIndex;?> = new Spry.Widget.CollapsiblePanel("<?php echo $divID;?>", {contentIsOpen:false});
</script>

<?php $tabIndex++;

	}
	
	$dbCountResult->close();
	$dbResultClient->close();
	$dbResult->close();
	$dbLink->close();


//Debug
	error_reporting(E_ALL);
	ini_set('display_errors',true);
?>

</table>




    <!-- end .content --></div>
<div id="footer"><span class="floatLeft">&nbsp;&nbsp;e:
    <script type='text/javascript'>//<![CDATA[
	  var a = new Array('.co.uk','circuitpro','info@');document.write("<a href='mailto:"+a[2]+a[1]+a[0]+"'>"+a[2]+a[1]+a[0]+"</a>");
	  //]]></script>
    &nbsp;&nbsp;</span><span class="floatRight">&copy;
    <?php 
ini_set('date.timezone','Europe/London');
$startYear = 2011;
$thisYear = date('Y');
if ($startYear == $thisYear) {
echo $startYear;
}
else {
echo "{$startYear} - {$thisYear}";
}
?>
    Circuit Pro Limited</span> </div>
</div>
</body>
</html>
