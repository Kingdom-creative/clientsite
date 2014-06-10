<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['username'])) {


//DB Details

	include ('db.php');
    
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
		
		
		//See if there are sort filters and adjust query
		
		if($_GET["sort"] == "projectname") {
			
	$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$_SESSION['_ID'].' AND live_PROJECT IS NOT NULL AND status_PROJECT = "Completed" ORDER BY title_PROJECT';
	
		} else {
	$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS _kp_PROJECT, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT, title_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$_SESSION['_ID'].' AND live_PROJECT IS NOT NULL AND status_PROJECT = "Completed" ORDER BY _added_PROJECT DESC';
		}
		
		$dbResultProject = $dbLink->query($dbProjectQuery);
		
		$project_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
	        
		
      }
      	catch(Exception $thisException)
	{
		include('/client/error.php');
	}
	
} else {

header("Location: /client/error_login.php");
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Circuit Pro - Client Area /<?php echo $clientDetail->name_CLIENT; ?>/ home</title>
<script type="text/javascript" src="/client/jquery.js"></script>
<script src="/client/SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script>
<link href="/client/clientside.css" rel="stylesheet" type="text/css" />
<link href="/client/SpryAssets/SpryCollapsiblePanel2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="loading">Updating data, please wait..</div>
<div id="container">
  <div id="header">
    <ul id="headernav">
      <li><form action="/client/<?php echo $_SESSION['username']; ?>/logout" method="post">
        <input name="logout" type="submit" value="Logout" />
      </form></li>
      <li><a href="/client/<?php echo $_SESSION['username']; ?>/home">Home</a>&nbsp;&nbsp;/&nbsp;&nbsp;</li>
    </ul>
    <div id="headertag"><span class="orange">CLIENT AREA_</span><?php $client = $clientDetail->name_CLIENT; $client=ucfirst(strtolower($client)); echo $client;?>
    <div class="floatRight">view by&nbsp;<a class="button<?php if($_GET["sort"] == "projectname") { echo ' selected';}?>" href="/client/<?php echo $_SESSION['username']?>/projects/sort-by-projectname">PROJECT</a><a class="button<?php if($_GET["sort"] == "completed") { echo ' selected';}?>" href="/client/<?php echo $_SESSION['username']?>/projects/sort-by-completed">DATE</a></div>
    </div>
    <?php if ($clientDetail->youtubeStats_CLIENT)  { ?><a class="stats" href="/client/stats/index.php"><span>Live Stats</span></a><?php } ?>
    
    
    
  </div>
  <div class="content">
    <table width="90%" align="center">
      <tr>
        <td class="table-head" colspan="2">
         <span class="orange"> Project<span class="date-added">Date Added</span></span>
          </td>
        <?php
			
			$tabIndex = 0;
			
			
while( $projectData = $dbResultProject->fetch_object()) {
		
		$divID = str_replace(' ', '', $projectData->title_PROJECT);
		?>
      <tr>
        <td colspan="2"><div id="<?php echo $divID;?>" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="<?php echo $tabIndex;?>"><?php echo $projectData->title_PROJECT;?><span class="date-added"><?php echo $projectData->added_PROJECT;?></span></div>
            <div class="CollapsiblePanelContent">
<?php

	
	//Get individual video items for each project
	$dbVideoQuery = 'SELECT _kp_VIDEO, title_VIDEO, youtubeID_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'" ORDER BY _added_VIDEO DESC';
	$dbVideoResult = $dbLink->query($dbVideoQuery);
	
	//cycle through any films
	while ($videoData = $dbVideoResult->fetch_object()) {
		
		$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $videoData->title_VIDEO);
		
		if($videoData->youtubeID_VIDEO) {?>
              <div class="filmlink"><a href="film/<?php echo $projectData->_kp_PROJECT;?>-<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>"><?php echo $videoData->title_VIDEO;?></a>&nbsp;&nbsp;<a href ="http://www.youtube.com/watch?v=<?php echo $videoData->youtubeID_VIDEO;?>)" class="live" target="_blank"></a></div>
              <?php	
			
		} else {?>
              <div class="filmlink"><a href="film/<?php echo $projectData->_kp_PROJECT;?>-<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>"><?php echo $videoData->title_VIDEO;?></a></div>
              <?php
	 }}
			?>
            
            </div>
          </div>          </td>
      </tr>
      <script type="text/javascript">
var CollapsiblePanel<?php echo $tabIndex;?> = new Spry.Widget.CollapsiblePanel("<?php echo $divID;?>", {contentIsOpen:false});
</script>
      <?php
			
	$tabIndex++;
	
	
	 }
	

	$dbResultProject->close();
	$dbResultClient->close();
	$dbLink->close();

?>
      
    </table>

    <!-- end .content -->
  </div>
  <div id="footer"><span class="floatLeft">&nbsp;&nbsp;e:
    <script type='text/javascript'>//<![CDATA[
	  var a = new Array('.co.uk','circuitpro','info@');document.write("<a href='mailto:"+a[2]+a[1]+a[0]+"'>"+a[2]+a[1]+a[0]+"</a>");
	  //]]></script>
    &nbsp;&nbsp;</span><span class="floatRight">&copy;
     <?php 
echo date('Y');
?>
    Circuit Pro Limited</span> </div>
  <!-- end .container -->
</div>
</body>
</html>
