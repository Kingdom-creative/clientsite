
<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<?php

		//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	$localPage="projects";
	$_SESSION['returnPage'] = currentPageURL();
	

	
	//Then fetch the user record

	$client = fetchClientData("username_CLIENT",$_SESSION['username']); 
	

//Set up page numbering
	if(empty($_GET['page'])) { $pageNum = 1; } else {
	$pageNum = (int) $_GET['page']; }
	if($pageNum <= 1) { 
	$pageLimit = PROJECT_RESULTS_PER_PAGE;
	$currPage = 0; } else {
	
	$pageLimit = PROJECT_RESULTS_PER_PAGE;
	$currPage = ($pageNum - 1) * PROJECT_RESULTS_PER_PAGE;	}
	
	
?>


<?php include ('head.php'); ?>

<! Containers >
<div id="container-fluid">
     <div class="row-fluid">
    <div class="span12">
  
<? include ('sidebar.php'); ?>


<div id="header-side-dash"><i class="icon-hdd"></i> Click on <i class="icon-angle-down"></i> to view each project<br>
<div class="tab-added"><a href="<?php echo $client->username_CLIENT; ?>/home"><i class="icon-hdd"></i> <u>View active projects</u></a><br>
<i class="icon-hdd"></i> <a href="<?php echo $client->username_CLIENT; ?>/logout"><u>Logout</u></a>
</div>

</div>

<div class="clearboth"></div>


  <div class="accordion-group">
<div class="accordion-heading-orange"><i class="icon-folder-close"></i>Completed Projects<span style="float: right">

    <span style="float: right" class="hide-resp">Date Added</span>
    </div>

</div>

<?php $counter = 1; 
	
	
	if($pageNum > 1) {
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,$currPage,$pageLimit); } else {
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,"","");	
	}
	
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,$currPage,$pageLimit);
	$counter = 1;
	
?>

<?php while( $projectData = $completedProjects->fetch_object()) { ?>


<div class="accordion" id="accordion<? echo $counter; ?>">
  <div class="accordion-group">
<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<? echo $counter; ?>" href="#collapse<? echo $counter; ?>">



<i class="icon-angle-down"></i> <? echo $projectData->title_PROJECT; ?> <? if($projectData->youtubeStats_PROJECT){ ?>
<? $projectViews = getProjectYoutubeViewCount($projectData->_kp_PROJECT); ?>
<span class="views"><i class="icon-desktop"></i><? echo number_format($projectViews->viewsTotal_PROJECT); ?> views</span><? } ?>


<span class="date-added"> <?php echo $projectData->added_PROJECT;?></span>
</a>
</div>
<div id="collapse<? echo $counter; ?>" class="accordion-body collapse">
<div class="accordion-inner compl">
<div class="span12">

<? 
	$videoTabResult = fetchProjectVideos($projectData->_kp_PROJECT);
	$videoResult = fetchProjectVideos($projectData->_kp_PROJECT);
	
?>


<div class="tabbable tabs-left">
<ul class="nav nav-tabs">
<? while ($videoData = $videoTabResult->fetch_object()) { 

$title_VIDEO = str_replace(' -','',$videoData->title_VIDEO);

$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $title_VIDEO); ?>

							  
							    <li><a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>" ><i class="icon-play-circle"></i> <? echo $videoData->title_VIDEO; ?></a>
							    
							    <?
							    
							    //Show Youtube Stats if applicable 
							    
							    	if($projectData->youtubeStats_PROJECT || $videoData->youtubeID_VIDEO) {
								    $video_ID = $videoData->youtubeID_VIDEO;
								    $JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_ID}?v=2&alt=json");
								    $JSON_Data = json_decode($JSON);
								    $views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
								    $rating = $JSON_Data->{'entry'}->{'yt$rating'}->{'numLikes'}; 
								    
								    
								    //Write back current number of YouTube views into our database
								    
								    if($views) {
									    
									updateYoutubeViewCount($videoData->_kp_VIDEO,$views);
									    
								    }
								    
								    
								    ?>
								    
								    
								   
								    
							      <div class="youtube hide-resp"><a href="http://www.youtube.com/watch?v=<? echo $videoData->youtubeID_VIDEO; ?>"><i class="icon-desktop"></i> Views: <strong><? echo number_format($views); ?></strong> l <i class="icon-thumbs-up"></i> Likes: <strong><? echo $rating; ?></strong></a></div> <? } ?>
							    
							    </li>
							    
							    <? } ?>
					
							</ul>
							

							   
							</div><!-- /.tabbable -->
</div>

<div class="clearboth"></div>

</div>



</div>
</div>

<? $counter++; ?>

<? } /*END WHILE PROJECT */ ?>

</div>

<ul class="pagebar">
 <li>Page&nbsp;</li>
    
     <?php $totalPages = ceil((fetchProjectCount($client->_kp_CLIENT,"Completed")) / PROJECT_RESULTS_PER_PAGE);
	 
	 $pageIndex = 1;
	 
	 while ($pageIndex <= $totalPages) {
     
     if($pageIndex == $pageNum) { ?>
      <li class="active"><?php echo $pageIndex; ?></li>
      <?php } else { ?>
      <li><a href="<? echo $_SESSION['username']; ?>/projects/page-<?php echo $pageIndex; ?>"><?php echo $pageIndex; ?></a></li>
      <?php 
         }		
		$pageIndex++; 
	 }
  ?>
     
</ul>
</div><!-- END Container-->


	</div><!-- /promoted -->

    <!-- end .content -->
  </div>
  
  </body>
</html>
