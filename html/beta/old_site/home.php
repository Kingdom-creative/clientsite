<?php

include ('db.php');
include ('functions.php');

ini_set('date.timezone','Europe/London');
session_start();

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
		
		
	$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT, DATE_FORMAT(date_firstDelivery_PROJECT, "%e %b %Y") AS firstDelivery_PROJECT, DATE_FORMAT(date_approval_PROJECT, "%e %b %Y") AS approval_PROJECT, DATE_FORMAT(date_finalDelivery_PROJECT, "%e %b %Y") AS finalDelivery_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$_SESSION['_ID'].' AND live_PROJECT IS NOT NULL AND status_PROJECT = "Active" ORDER BY _added_PROJECT DESC';
		
		
		$dbResultProject = $dbLink->query($dbProjectQuery);
		
		$project_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
	        
		if (! $project_found) {
			
			header("Location: /client/".$_SESSION['username']."/projects");
			
		}
		
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


  
	<link rel="stylesheet" type="text/css" media="all" href="/client/includes/dualslider/css/jquery.dualSlider.0.2.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/client/includes/dualslider/css/clearfix.css" />

	<script src="/client/includes/dualslider/scripts/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="/client/includes/dualslider/scripts/jquery.easing.1.3.js" type="text/javascript"></script>
	<script src="/client/includes/dualslider/scripts/jquery.timers-1.2.js" type="text/javascript"></script>
	<script src="/client/includes/dualslider/scripts/jquery.dualSlider.0.3.js" type="text/javascript"></script>


<script type="text/javascript">
		
		$(document).ready(function() {
			
			$(".carousel").dualSlider({
				auto:false,
				autoDelay: 6000,
				easingCarousel: "swing",
				easingDetails: "easeOutBack",
				durationCarousel: 1000,
				durationDetails: 600
			});
			
		});
		
	
		
	</script>

</head>
<body>
<div id="loading">Loading dashboard data..</div>
<div id="container">
  <div id="header">
    <ul id="headernav">
    
      <li><form action="/client/<?php echo $_SESSION['username']; ?>/logout" method="post">
        <input name="download" type="submit" value="Logout" />
      </form></li>
    </ul>
    <div id="headertag"><span class="orange">CLIENT AREA_</span><?php $client = $clientDetail->name_CLIENT; $client=ucfirst(strtolower($client)); echo $client;?>
    </div>
    
    
    
  </div>
  <div class="content">
    <table width="90%" align="center">
      <tr>
        <td colspan="2" style="padding-left:45px;line-height:38px;font-size:16px;background-color: #e6e6e6;background-image: url(../images/active.png);background-repeat: no-repeat;background-position: 5px center;">
         <span class="orange">Active Project Dashboard<span class="date-added">Date Added</span></span>
          </td></tr>
        <?php
			
			$tabIndex = 0;
			
			
while( $projectData = $dbResultProject->fetch_object()) {
		
		$divID = str_replace(' ', '', $projectData->title_PROJECT);
		?>
      <tr>
        <td colspan="2"><div id="<?php echo $divID;?>" class="CollapsiblePanel">
            <div class="CollapsiblePanelTab" tabindex="<?php echo $tabIndex;?>"><?php echo $projectData->title_PROJECT;?><span class="date-added"><?php echo $projectData->added_PROJECT;?></span></div>
            <div class="CollapsiblePanelContent">
            
     <h3 class="filmlink">Key Questions</h3>       
	<p class="orange">What do you want to achieve with the project?</p>
	<p><?php echo nl2br($projectData->check1_achieve_PROJECT); ?></p>
	
	  <p class="orange">What duration are the film(s) going to be?</p>
	<p><?php echo nl2br($projectData->check4_duration_PROJECT); ?></p>
    
    <p class="orange">How/where will the film(s) be viewed?</p>
	<p><?php echo nl2br($projectData->check2_platform_PROJECT); ?></p>
    
    <p class="orange">What video format do you need the film(s) to be in?</p>
	<p><?php echo nl2br($projectData->check3_format_PROJECT); ?></p>
    
    
    <p class="orange">What graphics appear during the film(s)?</p>
	<p><?php echo nl2br($projectData->check5_graphics_PROJECT); ?></p>
	
	<p class="orange">Any additional points to note?</p>
	<p><?php echo nl2br($projectData->notes_ext_PROJECT); ?></p>
    
    <hr />
    
    <h3 class="filmlink">Key Dates</h3> 
    <p><span class="orange">First Edit Delivered:</span>&nbsp;<?php echo $projectData->firstDelivery_PROJECT; ?></p>
    <p><span class="orange">Client Feedback/Approval:</span>&nbsp;<?php echo $projectData->approval_PROJECT; ?></p>
    <p><span class="orange">Final Edit Delivered:</span>&nbsp;<?php echo $projectData->finalDelivery_PROJECT; ?></p>
    
    <hr />
    
    <h3 class="filmlink">Key Staff</h3>
    <?php $prodManagerData = fetchStaffviaID($projectData->_kf_staff_prodManager_PROJECT); ?>
    <p><span class="orange">Production Manager:</span>&nbsp;<?php printf('<a href="mailto:%s?subject=%s" class="greyLink">%s</a>',$prodManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->name_STAFF); ?>					</p>
    <?php $creativeManagerData = fetchStaffviaID($projectData->_kf_staff_creativeManager_PROJECT); ?>
    <p><span class="orange">Creative Manager:</span>&nbsp;<?php printf('<a href="mailto:%s?subject=%s&cc=%s" class="greyLink">%s</a>',$creativeManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$creativeManagerData->name_STAFF); ?>					</p>
    <?php $editorData = fetchStaffviaID($projectData->_kf_staff_editor_PROJECT); ?>
    <p><span class="orange">Editor:</span>&nbsp;<?php printf('<a href="mailto:%s?subject=%s&cc=%s" class="greyLink">%s</a>',$editorData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$editorData->name_STAFF); ?>					</p>
    
    <hr />
    
 <!--   <h3 class="filmlink">Quotes</h3> 
    
    <hr />-->

<?php	
	//Get individual video items for each project
	$dbVideoQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectData->_kp_PROJECT.'" ORDER BY _added_VIDEO DESC';
	$dbVideoResult = $dbLink->query($dbVideoQuery);
	
	$films_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
	
	if($films_found) {
		
	  echo '<h3 class="filmlink">Delivered Films</h3>'; } 
	
	//cycle through them
	while ($videoData = $dbVideoResult->fetch_object()) {
		
		$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $videoData->title_VIDEO); ?>
		
		
		
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
	
	<img src="/client/images/Video-Not-Available.jpg" width="520" height="293" alt="Preview Not Available" />
	
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
      
    </table> <?php } ?>
		
		

            <p>&nbsp;</p>
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
	<tr>
        <td class="table-head" colspan="2">&nbsp;
          </td></tr>
    <tr>
        <td colspan="2" style="padding-left:45px;line-height:38px;font-size:16px;background-color: #e6e6e6;background-image: url(../images/completed.png);background-repeat: no-repeat;background-position: 5px center;">
         <a href="projects" class="orange">View All Completed Projects&nbsp;&gt;&gt;</a>
          </td></tr>
      
    </table>
    
	<p>&nbsp;</p>
	
	 <table width="90%" align="center">
      <tr>
        <td colspan="2" style="padding-left:45px;line-height:38px;font-size:16px;background-color: #e6e6e6;background-image: url(../images/question.png);background-repeat: no-repeat;background-position: 5px center;">
         	<span class="orange">What have we been up to?</span>
          	</td>
      </tr></table>
	
<div class="promoted">

  
  <div class="carousel clearfix">

			<div class="panel">
				
				<div class="details_wrapper">
				
				
					
					<div class="details">
					
					<?php 
						$promotedVideos = fetchPromotedFilms();
					
					while ($promotedVideoData = $promotedVideos->fetch_object()) {
					
					printf ('<div class="detail">
							<h3 class="orange">%s</h3><p style="color:white;">%s</p>
						</div><!-- /detail -->',$promotedVideoData->title_PROJECT,$promotedVideoData->desc_VIDEO);
						
							
						 } ?>
						
					
					</div><!-- /details -->
					
							
					
				</div><!-- /details_wrapper -->
				
		
				
				<div class="paging">
					<div id="numbers"></div>
					<a href="javascript:void(0);" class="previous" title="Previous" >Previous</a>
					<a href="javascript:void(0);" class="next" title="Next">Next</a>
				</div><!-- /paging -->
				
				<a href="javascript:void(0);" class="play" title="Turn on autoplay">Play</a>
				<a href="javascript:void(0);" class="pause" title="Turn off autoplay">Pause</a>
				
			</div><!-- /panel -->
	
			<div class="backgrounds">
			
			
			<?php 
					
					$promotedVideos = fetchPromotedFilms();
			
					$item = 1;
			
					while ($promotedVideoData = $promotedVideos->fetch_object()) {
				
					
					
					printf ('<div class="item item_%d">
					<iframe id="player%d" src="http://player.vimeo.com/video/%d?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;color=c06715" width="600" height="338" frameborder="0"></iframe>
				</div><!-- /item -->',$item,$item,$promotedVideoData->vimeoID_VIDEO);
					
					$item++;	
							
						 } ?>
				
				
			</div><!-- /backgrounds -->
			
			
		</div>


	</div><!-- /promoted -->

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
