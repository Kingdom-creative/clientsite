<?php

ini_set('date.timezone','Europe/London');
session_start();

//Fuction declarations

	function fileExists($path){
    return (@fopen($path,"r")==true);  }

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
			'SELECT * FROM client WHERE _kp_CLIENT = "%d"',$_GET['client']);
				
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
		
	$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS _kp_PROJECT, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT, title_PROJECT, status_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$_GET['client'].' ORDER BY _added_PROJECT DESC LIMIT 20';
	
		
		$dbResultProject = $dbLink->query($dbProjectQuery);
		
		$project_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
	        
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}
	
} else {

header("Location: error_login.php");
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Area / <?php echo $clientDetail->name_CLIENT; ?></title>

<script type="text/javascript" src="../jquery.js"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script>

<script type="text/javascript" language="JavaScript1.2">

<!--

function confirmDeleteFilm(title)
{
	
var agree=confirm("Are you sure you wish to delete the film - " + title + " ?");
if (agree)
	return true ;
else
	return false ;
}

function confirmDeleteProject(title)
{
	
var agree=confirm("Are you sure you wish to delete the project - " + title + " ?");
if (agree)
	return true ;
else
	return false ;
}

// -->

</script>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="loading">  
 <img src="../loader.gif" alt="loading.." />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading client data, please wait.. 
</div>  

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
    <h2><a href="home.php" class="cp_form_button">Client Admin Home</a></h2>
	
	<h2>Client: <?php echo $clientDetail->name_CLIENT; ?></h2>
 
    <table width="750" class="content" align="center">
      <tr>
        <td width="79%"><strong>Project</strong></td>
    <td width="21%" align="left"><strong>
    Added</strong>
	
    </td>
 
 
<?php
			
			$tabIndex = 0;
			
			
while( $projectData = $dbResultProject->fetch_object()) {
		
			//Write out the rows to display
	  	//	echo '<tr><td>'. $projectData->title_PROJECT . '</td>';
		
		$divID = str_replace(' ', '', $projectData->title_PROJECT);
	
	if($projectData->status_PROJECT == "Active") { printf('<tr><td>
      <div id="%s" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="%d">%s&nbsp;<span class="orange">Active</span></div>
          <div class="CollapsiblePanelContent">',$divID,$tabIndex,$projectData->title_PROJECT); } else {
	
	printf('<tr><td>
      <div id="%s" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="%d">%s</div>
          <div class="CollapsiblePanelContent">',$divID,$tabIndex,$projectData->title_PROJECT); }

	
	//Get individual video items for each project
	$dbVideoQuery = 'SELECT _kp_VIDEO, title_VIDEO, vimeoID_VIDEO, password_VIDEO,link_QT_VIDEO,link_WMV_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'" ORDER BY _added_VIDEO DESC';
	$dbVideoResult = $dbLink->query($dbVideoQuery);
	
	//cycle through them
	while ($videoData = $dbVideoResult->fetch_object()) {
		
		printf('<div class="showFilm"><h2>%s</h2>',$videoData->title_VIDEO);
		
	if($videoData->vimeoID_VIDEO) {
	
	printf('<div class="vimeo"><a href="https://vimeo.com/%s" target="_blank"><img src="../images/view-on-vimeo.jpg" width="260" height="146" alt="View on Vimeo" /></a></div>',$videoData->vimeoID_VIDEO);
	
 } else {
	
	printf('<div class="vimeo"><img src="../images/Video-Not-Available.jpg" width="260" height="146" alt="Preview Not Available" /></div>');
	
 }  
		if(empty($videoData->password_VIDEO)) { $password = "None"; } else { $password = $videoData->password_VIDEO; } 
		
		printf('<div class="videoData">
		<p>Password: %s</p>
		<p><a href="editFilm.php?film=%d" class="cp_form_button">&nbsp;&nbsp;Edit&nbsp;&nbsp;</a></p>
		<p><a href="deleteFilm.php?film=%d" class="cp_form_button" onClick="return confirmDeleteFilm(\'%s\')">Delete</a></p>',$password,$videoData->_kp_VIDEO,$videoData->_kp_VIDEO,$videoData->title_VIDEO);
		

		printf('<p>');
        if ($videoData->link_QT_VIDEO) {
	 
	 $file_name_qt = rawurlencode($videoData->link_QT_VIDEO);
	 $file_path_qt = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name_qt; }
	 
	if ($videoData->link_QT_VIDEO) {
			
		printf('<a href="%s" class="cp_form_button"><img src="../images/qt-symbol.png" width="15" height="15" /></a>',$file_path_qt); }
		
		
	if ($videoData->link_WMV_VIDEO) {
	 
	 $file_name_wmv = rawurlencode($videoData->link_WMV_VIDEO);
	 $file_path_wmv = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name_wmv; }
	 
	if ($videoData->link_WMV_VIDEO) {
			
		printf('<a href="%s" class="cp_form_button"><img src="../images/wm-symbol.png" width="15" height="15" /></a>',$file_path_wmv); }
		
		
		
		
		
		printf('</p></div><br style="clear: left;" /></div>');
	
	
	
	}
	
	printf('<div class="showFilm"><span style="margin-left:10px;margin-top:10px;"><a href="editProject.php?project=%d" class="cp_form_button">Edit Project</a>&nbsp;&nbsp;<a href="deleteProject.php?project=%d" onClick="return confirmDeleteProject(\'%s\')" class="cp_form_button">Delete Project</a></span>
	
	
	</div>',$projectData->_kp_PROJECT,$projectData->_kp_PROJECT,$projectData->title_PROJECT);
			
	  	  	echo '</div>
          </div>
        </td><td valign="top">'. $projectData->added_PROJECT . '</td></tr>';
		
		//Create Variable for Each Panel
		printf('<script type="text/javascript">
var CollapsiblePanel%d = new Spry.Widget.CollapsiblePanel("%s", {contentIsOpen:false});
</script>',$tabIndex,$divID);

			
	$tabIndex = $tabIndex + 1;
	
	
	 }
	

	$dbResultProject->close();
	$dbResultClient->close();
	$dbLink->close();

?>

<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="logout.php" method="post" style="display: inline"><input name="download" type="submit" value="Logout" class="cp_form_button"/></form></td>
</tr>

</table>

	<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
</div>
</body>
</html>
