<?php

include ('db.php');
include ('functions.php');

	

ini_set('date.timezone','Europe/London');
session_start();

$_SESSION['returnPage'] = currentPageURL();

if (isset($_SESSION['username'])) {

	
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
		$dbProjectQuery = 'SELECT * FROM project WHERE _kp_PROJECT = '.$_GET['project'].'';
		
		$dbResultProject = $dbLink->query($dbProjectQuery);
		$projectDetail = $dbResultProject->fetch_object();
		
          
		//Get the video detail to display
		 
		$dbVideoQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO FROM video WHERE _kp_VIDEO = '.$_GET['film'];
		
		$dbResultVideo = $dbLink->query($dbVideoQuery);
		
		$videoData = $dbResultVideo->fetch_object();
	        
		
      }
      	catch(Exception $thisException)
	{
		include('/client/error.php');
	}
	
} else {

header("Location: /client/");
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="/client/jquery.js"></script>
<script src="/client/SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="/client/clientside.css" rel="stylesheet" type="text/css" />
<link href="/client/SpryAssets/SpryCollapsiblePanel2.css" rel="stylesheet" type="text/css" />
<title>Circuit Pro - Client Area /<?php echo $clientDetail->name_CLIENT; ?>/<?php echo $projectDetail->title_PROJECT; ?></title>
</head>
<body>
<div id="container">
  <div id="header">
     <ul id="headernav">
      <li><form action="/client/<?php echo $_SESSION['username']; ?>/logout" method="post">
        <input name="logout" type="submit" value="Logout" />
      </form></li>
      <li><a href="/client/<?php echo $_SESSION['username']; ?>/home">Home</a>&nbsp;&nbsp;/&nbsp;&nbsp;</li>
    </ul>
    <div id="headertag"><span class="orange">CLIENT AREA_</span><?php $client = $clientDetail->name_CLIENT; $client=ucfirst(strtolower($client)); echo $client;?>_<span class="white"><?php echo $projectDetail->title_PROJECT; ?></span></div>
  </div>
  <div class="content">
    <table width="90%" align="center">
      <tr>
        <td colspan="2" class="table-head"><?php echo $videoData->title_VIDEO; ?></td>
      </tr>
      <tr class="film-holder">
        <td width="600" rowspan="2"><?php 

	if($videoData->youtubeID_VIDEO) {?>
    
          <iframe class="youtube-player" type="text/html" width="560" height="315" src="http://www.youtube.com/embed/<?php echo $videoData->youtubeID_VIDEO;?>?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
          
		  <?php } else {
			
	if($videoData->vimeoID_VIDEO) {?>
	
	<iframe src="http://player.vimeo.com/video/<?php echo $videoData->vimeoID_VIDEO;?>?title=0&amp;byline=0&amp;portrait=0&amp;color=c06715" width="520" height="293" frameborder="0"></iframe>
	
<?php } else {?>
	
	<img src="/client/images/Video-Not-Available.jpg" width="520" height="293" alt="Video Not Available" />
	
<?php } } ?>
</td>
        <td class="details">
        <p>Added: <span class="orange"><?php echo $videoData->added_VIDEO; ?></span></p>
        
          <?php if ($videoData->password_VIDEO && $videoData->vimeoID_VIDEO && empty($videoData->youtubeID_VIDEO)) { ?>
          
          <p>Password: <span class="orange"><?php echo $videoData->password_VIDEO;?></span></p>
          
          <?php }?>
         
          <?php if ($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO || $videoData->link_iPhone_VIDEO || $videoData->link_other_VIDEO) { ?>
          <h3>Video Download Options</h3>


<!-- QUICKTIME -->
          <?php if ($videoData->link_QT_VIDEO) {
	
	 
	 switch($videoData->videoBucket_VIDEO) {
	 
	 case "1":
	 $file_name = rawurldecode($videoData->link_QT_VIDEO);
	 $file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 case "2":
	 $file_name = rawurlencode($videoData->link_QT_VIDEO);
	 $file_path = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 }
	 
	 
	if (fileExists($file_path)) {
			
		printf('<a href="%s" class="downloadlink">QuickTime</a>',$file_path);
			
		} }?>



<!-- WMV -->
<?php if ($videoData->link_WMV_VIDEO) {
	
	
 switch($videoData->videoBucket_VIDEO) {
	 
	 case "1":
	 $file_name = rawurldecode($videoData->link_WMV_VIDEO);
	 $file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 case "2":
	 $file_name = rawurlencode($videoData->link_WMV_VIDEO);
	 $file_path = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 }
	
	if (fileExists($file_path)) {
			
		printf('<a href="%s" class="downloadlink">Windows Media</a>',$file_path);
			
		} }?>


<!-- IPHONE -->
<?php if ($videoData->link_iPhone_VIDEO) {
	
	
	 switch($videoData->videoBucket_VIDEO) {
	 
	 case "1":
	 $file_name = rawurldecode($videoData->link_iPhone_VIDEO);
	 $file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 case "2":
	 $file_name = rawurlencode($videoData->link_iPhone_VIDEO);
	 $file_path = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 }
	
	
	
	 
	
	if (fileExists($file_path)) {
			
		printf('<a href="%s" class="downloadlink">iPhone Video</a>',$file_path);
			
		} }?>


<!-- FLV -->
<?php if ($videoData->link_FLV_VIDEO) {
	
	
	 switch($videoData->videoBucket_VIDEO) {
	 
	 case "1":
	 $file_name = rawurldecode($videoData->link_FLV_VIDEO);
	 $file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 case "2":
	 $file_name = rawurlencode($videoData->link_FLV_VIDEO);
	 $file_path = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 }
	 
	
	 
	
	if (fileExists($file_path)) {
			
		printf('<a href="%s" class="downloadlink">Flash Video FLV</a>',$file_path);
			
		} }?>


<!-- OTHER OR RAW -->
 
<?php if ($videoData->link_other_VIDEO) {
	
	
	 switch($videoData->videoBucket_VIDEO) {
	 
	 case "1":
	 $file_name = rawurldecode($videoData->link_other_VIDEO);
	 $file_path = 'video/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 case "2":
	 $file_name = rawurlencode($videoData->link_other_VIDEO);
	 $file_path = 'http://content.circuitpro.co.uk/'.$clientDetail->folder_CLIENT.'/'.$file_name;
	 break;
	 
	 }
	 
	
	
	
	if (fileExists($file_path)) {
			
		printf('<a href="%s" class="downloadlink">%s</a>',$file_path,$videoData->link_otherLabel_VIDEO);
			
		} }?>
		

<?php }	?>
          
          
        </td>
      <tr class="film-holder">
        <td valign="bottom">
		<?php if($videoData->youtubeID_VIDEO) { ?>
      <a href ="http://www.youtube.com/watch?v=<?php echo $videoData->youtubeID_VIDEO; ?>" class="live" target="_blank"></a>
      <?php } ?></td>
      <tr>
        <td colspan="2"></td>
      </tr>
      
    </table>
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
</div>
</body>
</html>
<?php

        $dbResultClient->close();
		$dbResultVideo->close(); 
		$dbLink->close();
?>
