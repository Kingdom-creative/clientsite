<?php 



ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['username'])) {


//DB Details

	include ('../db.php');
    
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

<title>Circuit Pro - Client Area / <?php echo $clientDetail->name_CLIENT; ?> / live stats</title>

<script type="text/javascript" src="../jquery.js"></script>  
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script>  

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a>

<div id="loading">  
 <img src="../loader.gif" alt="loading.." />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Getting data... 
</div>  
    <div id="youtube_logo">  
</div> 
  
    <!-- end .header --></div>
    

    
  <div class="content">
    <h2><a href="../home.php">Client Area / <?php echo $clientDetail->name_CLIENT; ?></a> / live stats</h2>
    
    <table width="96%" class="heading" align="center">
          <tr>
        <td align="right" bgcolor="#FFFFFF"><strong><a href="breakdown.php">View by Project</a></strong></td>
      </tr>
    </table>
	
<?php
	  
	  //Load in our variables and libraries

$clientLibraryPath = '../ZendGdata/library';
$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);
require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path

Zend_Loader::loadClass('Zend_Gdata_YouTube');
$yt = new Zend_Gdata_YouTube();
$yt->setMajorProtocolVersion(2);

//DB Details

$viewsCount = 0;


	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		

?>

    <p>&nbsp;</p>
    <table width="96%" class="content" align="center">
      <tr>
        <td width="53%"><strong>Title</strong></td>
<!--    <td width="44%"><strong>Title</strong></td>-->
    <td width="18%"><strong><?php if($_GET["sort"] == "views") { ?><a href="index.php">Added</a><?php } else { ?>Added<?php } ?></strong></td>
    <td width="15%"><strong>Av.Rating</strong></td>
    <td width="14%" align="right"><strong>
    <?php if($_GET["sort"] != "views") { ?><a href="index.php?sort=views">Views</a><?php } else { ?>Views<?php } ?></strong></td>
  </tr>
 
<?php

//Debug
	error_reporting(E_ALL);
	ini_set('display_errors',true);

function printVideoEntry($videoEntry, $added, $thumbnail) 
{
  // the videoEntry object contains many helper functions
  // that access the underlying mediaGroup object
//  echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
//  echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
//  echo 'Updated: ' . $videoEntry->getUpdated() . "\n";

  $videoThumbnails = $videoEntry->getVideoThumbnails();
	$videoThumbnail = $videoThumbnails[0];
	$videoThumbnailURL = $videoThumbnail['url'];

echo '<tr style="height:7px">';
// echo '<td><a href="http://www.youtube.com/watch?v=' . $videoEntry->getVideoId(). '" border=0 target="_blank"><img src="images/'.$thumbnail.'" width="160" height ="146"></a></td>';
// echo '<td><a href="http://www.youtube.com/watch?v=' . $videoEntry->getVideoId(). '" border=0>'. $videoEntry->getVideoId() .'</a></td>';
	$video_title = $videoEntry->getVideoTitle();
	if (strlen($video_title) > 55) {
		$video_title = substr($video_title,0,55) . '...';
	}
  echo '<td><a href="http://www.youtube.com/watch?v='. $videoEntry->getVideoId() . '" target="_blank">'. $video_title .'</a></td>';
//  echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
//  echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
//  echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
//  echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
//  echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";

	echo '<td>'. $added . '</td>';

	$ratingArray = $videoEntry->getVideoRatingInfo();
	$avgRating = ($ratingArray['average'] * 2) *10;
	$avgRating = round($avgRating);

  echo '<td>'.$avgRating.'%</td>';
  echo '<td align="right">'. number_format($videoEntry->getVideoViewCount()).'</td>';

  
  // see the paragraph above this function for more information on the 
  // 'mediaGroup' object. in the following code, we use the mediaGroup
  // object directly to retrieve its 'Mobile RSTP link' child
/*  foreach ($videoEntry->mediaGroup->content as $content) {
    if ($content->type === "video/3gpp") {
      echo 'Mobile RTSP link: ' . $content->url . "\n";
    }
  } */
  
  echo '</tr>';
  
}


	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
	$dbWriteLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		
		if($_GET["sort"] == "views") {
		
	$dbQuery = 'SELECT _kp_VIDEO, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO, youtubeID_VIDEO, title_VIDEO, thumbnail_VIDEO from video LEFT JOIN project ON _kf_project_VIDEO = _kp_PROJECT LEFT JOIN client ON _kf_client_PROJECT = _kp_CLIENT WHERE _kp_CLIENT = '.$clientDetail->_kp_CLIENT.' AND video.youtubeStats_VIDEO IS NOT NULL ORDER BY youtubeViews_VIDEO DESC';
	
		} else {
			
	/*	NEW QUERY
		
			select _kp_VIDEO, title_VIDEO from video LEFT JOIN project ON `_kf_project_VIDEO` = `_kp_PROJECT` LEFT JOIN client ON `_kf_client_PROJECT` = `_kp_CLIENT` WHERE client.`_kp_CLIENT` = 2; */
		
			$dbQuery = 'SELECT _kp_VIDEO, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO, youtubeID_VIDEO, title_VIDEO, thumbnail_VIDEO from video LEFT JOIN project ON _kf_project_VIDEO = _kp_PROJECT LEFT JOIN client ON _kf_client_PROJECT = _kp_CLIENT WHERE _kp_CLIENT = '.$clientDetail->_kp_CLIENT.' AND video.youtubeStats_VIDEO IS NOT NULL ORDER BY _added_VIDEO DESC';
			
		}
		
	
		
		$dbResult = $dbLink->query($dbQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database');


	while( $videoData = $dbResult->fetch_object()) {
		
		$videoID = $videoData->youtubeID_VIDEO;
		$videoEntry = $yt->getVideoEntry($videoID);
		
		//*********** UDPDATE YOUTUBE TITLE
		
		$youTubeTitle = $videoEntry->getVideoTitle();
		
		// Get running total of views
		$viewsCount = $videoEntry->getVideoViewCount();
		
		//Write current hit count to DB
		$dbCountWriteQuery = 'UPDATE video SET youtubeViews_VIDEO = "'.(int)$viewsCount.'", youtubeTitle_VIDEO ="'.$youTubeTitle.'" WHERE youtubeID_VIDEO = "'.$videoID.'"';
	
		
		$dbWriteResult = $dbWriteLink->query($dbCountWriteQuery);
		
		$totalViewsCount = $totalViewsCount + $viewsCount;
		
		
		//Write out each video in row
		printVideoEntry($videoEntry, $videoData->added_VIDEO, $videoData->thumbnail_VIDEO);
		
	}	

	$dbResultClient->close();
	$dbLink->close();

?>

</table>

  <table width="96%" class="heading" align="center">
          <tr>
        <td width="86%" align="right" bgcolor="#8B8B8B"><strong>TOTAL VIEWS:&nbsp;&nbsp;&nbsp;</strong></td>
        <td width="14%" align="right" bgcolor="#8B8B8B"><strong><?php echo number_format($totalViewsCount); ?></strong></td>
      </tr>
       <tr>
        <td width="86%" align="right">&nbsp;</td>
        <td width="14%" align="right">&nbsp;</td>
      </tr>
      
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="../logout.php" method="post" style="display: inline"><input name="download" type="submit" value="Logout" /></form></td>
</tr>
    </table>


<br /><br />

<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 2011</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
