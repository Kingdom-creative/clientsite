<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['username'])) {

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
		
		//Get the details of the project itself
		$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS _kp_PROJECT, DATE_FORMAT(_completed_PROJECT, "%e %b %Y %H:%i") AS completed_PROJECT, title_PROJECT, desc_PROJECT FROM project WHERE _kp_PROJECT = '.$_GET['id'].'';
		
		$dbResultProject = $dbLink->query($dbProjectQuery);
		$projectDetail = $dbResultProject->fetch_object();
		
          
		//Get the array of videos for the project
		 
		$dbVideoQuery = 'SELECT SQL_CALC_FOUND_ROWS _kp_VIDEO, DATE_FORMAT(_added_VIDEO, "%e %b %Y %H:%i") AS added_VIDEO, title_VIDEO, length_VIDEO, vimeoID_VIDEO, password_VIDEO, link_QT_VIDEO, link_WMV_VIDEO, link_iPhone_VIDEO, link_FLV_VIDEO FROM video WHERE _kf_project_VIDEO = '.$_GET['id'].' ORDER BY _added_VIDEO DESC';
		
		$dbResultVideo = $dbLink->query($dbVideoQuery);
		
		$video_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
	        
		
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


<title>Circuit Pro - Client Area / <?php echo $clientDetail->name_CLIENT; ?> / <?php echo $projectDetail->title_PROJECT; ?></title>


<style type="text/css">

<!--
body {
	font: 75%/1.5 Verdana, Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	margin: 0;
	padding:15px;
	color: #8B8B8B;
}

/* ~~ Element/tag selectors ~~ */
ul, ol, dl { /* Due to variations between browsers, it's best practices to zero padding and margin on lists. For consistency, you can either specify the amounts you want here, or on the list items (LI, DT, DD) they contain. Remember that what you do here will cascade to the .nav list unless you write a more specific selector. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
	padding-right: 0px;
	padding-left: 0px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
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
	color: #8B8B8B;
	background-color: #EEE;
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
    <h2><a href="home.php">Client Area / <?php echo $clientDetail->name_CLIENT; ?></a> / <?php echo $projectDetail->title_PROJECT; ?></h2>

<?php if ($projectDetail->desc_PROJECT) {
	
	printf('Description: %s<br /><br />', $projectDetail->desc_PROJECT);
	
} ?>


<table width="700">
<tr><td>Films in Project: <?php echo $video_found; ?></td><td align="right"><a href="home.php">&lt;&nbsp;Back to Main Menu</a></td></tr></table>
<br /><br />

<?php if($video_found >= 1) { ?>

<table width="700">


<?php while( $tmp = $dbResultVideo->fetch_object() ) { ?>


<tr>
<td height="250" width="420" style="padding:10px;">
<?php if($tmp->vimeoID_VIDEO) {
	
	printf('<iframe src="http://player.vimeo.com/video/%d?title=0&amp;byline=0&amp;portrait=0&amp;color=c06715" width="420" height="250" frameborder="0"></iframe>',$tmp->vimeoID_VIDEO);
	
} else {
	
	echo '<img src="images/Video-Not-Available.jpg" width="420" height="250" alt="Video Not Available" />';
	
} ?>

</td>
<td align="left" valign="top" style="padding:10px;"><h2><?php echo $tmp->title_VIDEO; ?></h2>
<?php /*?>Running Time: <?php echo $tmp->length_VIDEO; ?> (mm:ss)<br /><br /><?php */?>
<?php if ($tmp->password_VIDEO) printf('<strong>Password: <span style="color:#FE7A1E;">%s</span></strong><br />',$tmp->password_VIDEO); ?>
Modified: <?php echo $tmp->added_VIDEO; ?><br /><br />


<?php if ($tmp->link_QT_VIDEO || $tmp->link_WMV_VIDEO || $tmp->link_FLV_VIDEO || $tmp->link_iPhone_VIDEO) { ?>
Download:<br />
<?php if ($tmp->link_QT_VIDEO) {
	$file_name = rawurldecode($tmp->link_QT_VIDEO);
	$file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	printf('<form action="download.php" method="post" style="display: inline"><input name="path" type="hidden" value="%s" /><input name="file" type="hidden" value="%s" /><input name="download" type="submit" value="Download Quicktime" /></form><br />',$file_path,$tmp->link_QT_VIDEO);
}?>
<?php if ($tmp->link_WMV_VIDEO) {
	$file_name = rawurldecode($tmp->link_WMV_VIDEO);
	$file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	printf('<form action="download.php" method="post" style="display: inline"><input name="path" type="hidden" value="%s" /><input name="file" type="hidden" value="%s" /><input name="download" type="submit" value="Download Windows Media" /></form><br />',$file_path,$tmp->link_WMV_VIDEO);
}?>


<?php } ?>
</td>


<?php } ?>

<tr style="color:#8B8B8B;
	background-color: #FFF;">
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="logout.php" method="post" style="display: inline"><input name="download" type="submit" value="Logout" /></form></td>
</tr>
</table>
<?php } ?>

<br /><br />
</div>
  

  
  <div class="footer">
    <p>&copy; Circuit Pro 
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
    </p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>

<?php

        $dbResultClient->close();
		$dbLink->close();
?>


