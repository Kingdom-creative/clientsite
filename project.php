<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<? 

	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	
	/* Need to load up vars before loading head */
	$projectData = fetchProjectData($_GET['project']); 
	
	$localPage = $projectData->title_PROJECT;
	$_SESSION['returnPage'] = currentPageURL();
	
	$client = fetchClientData("username_CLIENT",$_SESSION['username']);
	
	

	
?>

<?php include ('head.php'); ?>


<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>


<div class="downloaded"><div class="dw-yes"><span class="btn btn-primary">Your file is now downloading...</span></div></div>

<style>
.nav-pills > li:nth-child(1) > a{
	border: 1px solid #fff;
}
</style>


    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
      
      <div class="span7 title">
      <h2><span class="op-title">Project</span><br><?php echo $projectData->title_PROJECT; ?></h2>
      </div>
      
      <div class="span5 title-search">
<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return searchVerify();" class="form-inline align-right hidden-xs">
	      <input class="form-control" name="searchstring" type="text"  placeholder="Search content" />
	      <input class="btn btn-primary" name="submit" type="submit"  value="Search" />
	     
	  </form>
</div>
      
      </div>
      
      <div class="clearboth"></div>
      
      </div></div>
      

 <?  
            
            
   //See if there is a subfolder for downloads
   
   if(!empty($projectData->folder_PROJECT)) { $folder = $client->folder_CLIENT.'/'.$projectData->folder_PROJECT; } else { $folder = $client->folder_CLIENT; }
            
    
    	//Now fetch films for the project
    	
    	        
	$videoResult = fetchProjectVideos($projectData->_kp_PROJECT);
	
	if ($videoResult) { $totalVideos = $videoResult->num_rows; }
	
	
	if ($videoResult) { ?>
	
	<div class="container" id="single-projects">
      <div class="row">
	
      
      <!-- _____ -->
      <div id="videos">
      <div class="span12">
      <h2 class="list-sub">Films</h2>
      <?php if($totalVideos > 1) { ?>
      <h5 class="sub-title hidden-xs">Awesome films below</h5><?php } else { ?>
      <h5 class="sub-title hidden-xs">Awesome film below</h5><?php } ?>
      </div>
      </div>
     <div class="clearboth"></div>      
      
     
<?php $videoCount = 1; ?>

<?php while ($videoData = $videoResult->fetch_object()) {
	 

	$title_VIDEO = str_replace(' -','',$videoData->title_VIDEO);

	$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $title_VIDEO);
	
	 
	
	?>
	
	
	<?php if($totalVideos >= 3) { ?>
    

<div class="span4 thumbnail-options">
<div class="video-wrap small">
<? if($videoData->youtubeID_VIDEO) { ?>
<iframe width="280" height="158" src="//www.youtube.com/embed/<? echo $videoData->youtubeID_VIDEO; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
<? } else { ?>

<?php $vimeoThumb = getVimeoThumb($videoData->vimeoID_VIDEO); ?>

  <!-- <a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>/play"><img src="<?php echo $vimeoThumb; ?>" width="280" height="158" ></a> -->
  
  <iframe src="//player.vimeo.com/video/<?php echo $videoData->vimeoID_VIDEO; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=f28c3a" width="280" height="158" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

<? } ?>
          <div class="border"></div>
      <div class="video-info">
      <p class="list-text"><h4> <a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>"><? if(strlen($videoData->title_VIDEO) > 30) { echo substr($videoData->title_VIDEO,0,25).'...'; } else { echo $videoData->title_VIDEO; } ?></a></h4></p>
       <p class="video-info-loop">
       
       <!-- Version --> <?php if($videoData->version_VIDEO > 0) { echo '<span class="version">Version '.$videoData->version_VIDEO.'</span>'; } ?> 
      <!-- Timestamp --> <span class="time"><? echo time_elapsed_string($videoData->_added_VIDEO); ?></span>
      <!-- Password --> <span class="password"><?php if($videoData->password_VIDEO): ?><i class="fa fa-lock"></i><? echo $videoData->password_VIDEO; ?><?php else: ?><? endif; ?></span>
      </p>
       <form class="form-inline">
       <input type="text" value="http://kingdom-creative.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>" class="form-control shareLink-3" id="shareLink-<?php echo $videoData->_kp_VIDEO;?>" onClick="SelectAll('shareLink-<?php echo $videoData->_kp_VIDEO;?>')">
      <?php if($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO || $videoData->link_other_VIDEO) { ?>
      <div class="btn-group">
  <a class="btn btn-primary" data-toggle="dropdown" href="#"></i> Download</a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down"></span></a>
  <ul class="dropdown-menu">
  

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_QT_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/QT"><i class="fa fa-download fa-fw"></i> Quicktime</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_WMV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/WMV"><i class="fa fa-download fa-fw"></i> Windows Media</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_FLV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/FLV"><i class="fa fa-download fa-fw"></i> Flash FLV</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_other_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/Other"><i class="fa fa-download fa-fw"></i> <? echo $videoData->link_otherLabel_VIDEO; ?></a></li>
<? } ?>

</ul>
</div>
       </form>

 <?php } else { ?>
 <span class="downloads-un">No downloads</span>
 <?php } ?>
      
      </div>
</div> <!-- END video-wrap -->
      </div> <!-- END span4 -->

<?php if(($videoCount % 3) == 0) {
   echo "<div class='clearboth'></div>";
   
   
   }
   
   $videoCount++;
   
    } else if($totalVideos == 2) { //ONLY TWO FILMS ?>

<div class="span6 thumbnail-options">
<div class="video-wrap medium">

<? if($videoData->youtubeID_VIDEO) { ?>
<iframe width="280" height="158" src="//www.youtube.com/embed/<? echo $videoData->youtubeID_VIDEO; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
<? } else { ?>
      <iframe src="//player.vimeo.com/video/<?php echo $videoData->vimeoID_VIDEO; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=f28c3a" width="280" height="158" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
      
<? } ?>

      <div class="border"></div>
      <div class="video-info">
      <p class="list-text"><h4> <a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>"><? echo $videoData->title_VIDEO; ?></a></h4></p>
       <p class="video-info-loop">
       
       <!-- Version --> <?php if($videoData->version_VIDEO > 0) { echo '<span class="version">Version '.$videoData->version_VIDEO.'</span>'; } ?> 
      <!-- Timestamp --> <span class="time"><? echo time_elapsed_string($videoData->_added_VIDEO); ?></span>
      <!-- Password --> <span class="password"><?php if($videoData->password_VIDEO): ?><i class="fa fa-lock"></i><? echo $videoData->password_VIDEO; ?><?php else: ?><? endif; ?></span>
      </p>
      <form class="form-inline">
       <input type="text" value="http://kingdom-creative.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>" class="form-control shareLink-2" id="shareLink-<?php echo $videoData->_kp_VIDEO;?>" onClick="SelectAll('shareLink-<?php echo $videoData->_kp_VIDEO;?>')">
      <?php if($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO || $videoData->link_other_VIDEO) { ?>
      <div class="btn-group">
  <a class="btn btn-primary" data-toggle="dropdown" href="#"></i> Download</a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down"></span></a>
  <ul class="dropdown-menu">
  

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_QT_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/QT"><i class="fa fa-download fa-fw"></i> Quicktime</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_WMV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/WMV"><i class="fa fa-download fa-fw"></i> Windows Media</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_FLV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/FLV"><i class="fa fa-download fa-fw"></i> Flash FLV</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_other_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/Other"><i class="fa fa-download fa-fw"></i> <? echo $videoData->link_otherLabel_VIDEO; ?></a></li>
<? } ?>

</ul>
</div>
      </form>

 <?php } else { ?>
 <span class="downloads-un">No downloads</span>
 <?php } ?>
      <div class="clearboth"></div>
      </div>
</div> <!-- END video-wrap -->
      </div> <!-- END span4 -->

<?php  } else if($totalVideos == 1) { //ONLY ONE FILM ?>

<div class="span12 thumbnail-options">
<div class="video-wrap large">
<? if($videoData->youtubeID_VIDEO) { ?>
<iframe width="280" height="158" src="//www.youtube.com/embed/<? echo $videoData->youtubeID_VIDEO; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
	<? } else { ?>
      <iframe src="//player.vimeo.com/video/<?php echo $videoData->vimeoID_VIDEO; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=f28c3a" width="280" height="158" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
      <? } ?>
      
      <div class="border"></div>
      <div class="video-info">
      <p class="list-text"><h4> <a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>"><? echo $videoData->title_VIDEO; ?></a></h4></p>
       <p class="video-info-loop">
       
       <!-- Version --> <?php if($videoData->version_VIDEO > 0) { echo '<span class="version">Version '.$videoData->version_VIDEO.'</span>'; } ?> 
      <!-- Timestamp --> <span class="time"><? echo time_elapsed_string($videoData->_added_VIDEO); ?></span>
      <!-- Password --> <span class="password"><?php if($videoData->password_VIDEO): ?><i class="fa fa-lock"></i><? echo $videoData->password_VIDEO; ?><?php else: ?><? endif; ?></span>
      </p>
      
      
       <form class="form-inline">
       <input type="text" value="http://kingdom-creative.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>" class="form-control shareLink-1" id="shareLink-<?php echo $videoData->_kp_VIDEO;?>" onClick="SelectAll('shareLink-<?php echo $videoData->_kp_VIDEO;?>')">
      <?php if($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO ||  $videoData->link_other_VIDEO) { ?>
      <div class="btn-group">
  <a class="btn btn-primary" data-toggle="dropdown" href="#"></i> Download</a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down"></span></a>
  <ul class="dropdown-menu">
  

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_QT_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/QT"><i class="fa fa-download fa-fw"></i> Quicktime</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_WMV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/WMV"><i class="fa fa-download fa-fw"></i> Windows Media</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_FLV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/FLV"><i class="fa fa-download fa-fw"></i> Flash FLV</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_other_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/Other"><i class="fa fa-download fa-fw"></i> <? echo $videoData->link_otherLabel_VIDEO; ?></a></li>
<? } ?>

</ul>
</div>
       </form>

 <?php } else { ?>
 <span class="downloads-un">No downloads</span>
 <?php } ?>
      <div class="clearboth"></div>
      </div>
</div> <!-- END video-wrap -->
      </div> <!-- END span4 -->

<?php  } ?>



<? } /* END WHILE FILM */ ?>
      
<!--
 <div class="span12">
      <h4 class="list-sub"><i class="fa fa-bullhorn"></i>Help! I want to download or share my film!</h4>
      <p>If you want to download or share your film, simply click the <span class="primary-text">"Info"</span> button underneath film.</p>
      </div>
      
      <hr>
      
       <div class="span12">
      <h4 class="list-sub"><i class="fa fa-bullhorn"></i>I can't find the download links?</h4>
      <p>That's probably because they're not there. This is usually because the film hasn't been approved for download yet.</p>
      </div>
      </div>
-->

      
           
      </div>
    </div> <!-- /SINGLE-PROJECTS -->
    
      </div></div>
      
      
    
  <?php } ?>

  <!-- _____ END -->
  </div><!-- /#SINGLEPROJECTS -->
  

<?php /* Project Dates */ if($projectData->firstDelivery_PROJECT || $projectData->approval_PROJECT || $projectData->finalDelivery_PROJECT) { ?>

<div class="container"  id="deliverables">
<div class="row">
      
      <div class="span8">
      <h2>Deliverables</h2>
      <h5 class="sub-title hidden-xs">When to expect your content</h5>
      </div>
      
      <div class="clearboth"></div>
      <?php if ($projectData->filming_PROJECT) { ?>
      <div class="span6">
      <span class="date-title">Filming<span class="hidden-xs hide-ie"> Date</span></span>
      <span class="date-outline"><?php echo $projectData->filming_PROJECT; ?></span>
      </div>
      <?php } ?>
      
      <?php if ($projectData->firstDelivery_PROJECT) { ?>
      <div class="span6">
      <span class="date-title">First Edit<span class="hidden-xs hide-ie"> Delivered</span></span>
      <span class="date-outline"><?php echo $projectData->firstDelivery_PROJECT; ?></span>
      </div>
      <?php } ?>
      
      <?php if ($projectData->approval_PROJECT) { ?>
      <div class="span6">
      <span class="date-title">Feedback<span class="hidden-xs hide-ie"> & Approval</span></span>
      <span class="date-outline"><?php echo $projectData->approval_PROJECT; ?></span>
      </div>
      <?php } ?>
      
      <?php if ($projectData->finalDelivery_PROJECT) { ?>
      <div class="span6">
      <span class="date-title">Final Edit<span class="hidden-xs hide-ie"> Delivered</span></span>
      <span class="date-outline"><?php echo $projectData->finalDelivery_PROJECT; ?></span>
      </div>
      <?php } ?>
      
           
      
	</div>
	</div> <!-- /DELIVERABLES -->
	<?php } // Project Dates ?>


<?php if($projectData->brief1_aims_PROJECT || $projectData->brief2_audience_PROJECT || $projectData->brief3_broadcast_PROJECT || $projectData->brief4_keypoints_PROJECT || $projectData->brief5_duration_PROJECT) { ?>
    
    <!-- Brief INFO -->
<div class="container" id="brief-information">
<div class="row">
      
      <div class="span12">
      <h2>Brief Information</h2>
      <h5 class="sub-title hidden-xs">See all the information in one place</h5>
      </div>
      
      <div class="clearboth"></div>
      
      <!-- !AIMS -->
      <?php if (!empty($projectData->brief1_aims_PROJECT)) { ?>
      
      <div class="span1 project-tabs">
      <i class="fa fa-dot-circle-o"></i>
      </div>
      <div class="span11">
      <h3>Aim of the Project</h3>
      <p><?php print(nl2br($projectData->brief1_aims_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
	  <!-- !AUDIENCE -->
	  <?php if (!empty($projectData->brief2_audience_PROJECT)) { ?>
	  <div class="span1 project-tabs">
      <i class="fa fa-users"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Intended Audience</h3>
      <!-- <h5 class="sub-title hidden-xs">Internal (Sales / Management / All Staff) / External (Customers / Potential Customers / Enthusiasts)</h5> -->
      <p><?php print(nl2br($projectData->brief2_audience_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      <!-- !BROADCAST -->
      <?php if (!empty($projectData->brief3_broadcast_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-desktop"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Broadcast Channel</h3>
      <!-- <h5 class="sub-title hidden-xs">Television / social media / internet channels / downloadable file / event display screens</h5> -->
      <p><?php print(nl2br($projectData->brief3_broadcast_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      	
      <!-- !KEY POINTS -->
      <?php if (!empty($projectData->brief4_keypoints_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-key"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Key Points</h3>
      <!-- <h5 class="sub-title hidden-xs">In order of importance</h5> -->
      <p><?php print(nl2br($projectData->brief4_keypoints_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      <!-- !DURATION -->
      <?php if (!empty($projectData->brief5_duration_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-clock-o"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Duration</h3>
      <!-- <h5 class="sub-title hidden-xs">Please consider the number of key points to be included when stipulating the duration required</h5> -->
      <p><?php print(nl2br($projectData->brief5_duration_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      <!-- !STYLE -->
      <?php if (!empty($projectData->brief6_style_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-pencil"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Style</h3>
      <!-- <h5 class="sub-title hidden-xs">Training / Stylish / Fast Paced Action / Epic / Inspiring / Interview Based</h5> -->
      <p><?php print(nl2br($projectData->brief6_style_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      <!-- !EXAMPLES -->
      <?php if (!empty($projectData->brief7_examples_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-video-camera"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Example Films</h3>
      <p><?php print(nl2br(createLinks($projectData->brief7_examples_PROJECT))); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      <!-- !CAMPAIGN -->
      <?php if (!empty($projectData->brief8_campaign_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-paste"></i>
      </div>
      <div class="span11">
      <h3>Is the project part of a campaign?</h3>
      <p><?php print(nl2br($projectData->brief8_campaign_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      <div class="span12"><hr></div><?php } ?>
      
      
      <!-- !GRAPHICS -->
      <?php if (!empty($projectData->brief9_graphics_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-picture-o"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>What Graphics are required?</h3>
      <!-- <h5 class="sub-title hidden-xs">Call to action / logos / text</h5> -->
      <p><?php print(nl2br($projectData->brief9_graphics_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
      
      <div class="span12"><hr></div><?php } ?>
      
      
      <!-- !SUCCESS -->
      <?php if (!empty($projectData->brief10_success_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-thumbs-o-up"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>How will the success of the project be measured?</h3>
      <!-- <h5 class="sub-title hidden-xs">Sales / enquiries / views / comments</h5> -->
      <p><?php print(nl2br($projectData->brief10_success_PROJECT)); ?></p>
      </div>
      <div class="clearboth"></div>
       <div class="span12"><hr></div><?php } ?>
      
  
      
      <!-- !APPROVAL -->
  
      <?php if (!empty($projectData->brief_clientApproval_PROJECT)) { ?>
      <div class="span1 project-tabs">
      <i class="fa fa-check-circle"></i>
      </div>
      <div class="col-xs-12 col-sm-9 span11">
      <h3>Who has ultimate approval of the project?</h3>
      <!-- <h5 class="sub-title hidden-xs">Sales / enquiries / views / comments</h5> -->
      <p><?php print $projectData->brief_clientApproval_PROJECT; ?></p>
      </div>
      <div class="clearboth"></div>
       <div class="span12"><hr></div>
             
       <?php } ?>
            
     
<div class="hidden-xs col-sm-2 span1 project-tabs">
      <i class="fa fa-user"></i>
      </div>
<div class="span10">
      <h3>Key Staff</h3>
							      
	<?php if($projectData->_kf_staff_prodManager_PROJECT) {  $prodManagerData = fetchStaffviaID($projectData->_kf_staff_prodManager_PROJECT); ?>
							      <p><strong>Production Manager</strong><br><?php printf('<a href="mailto:%s?subject=%s">%s <i class="fa fa-envelope-o"></i></a>',$prodManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->name_STAFF); ?></p><?php } ?>

<?php if($projectData->_kf_staff_creativeManager_PROJECT) { $creativeManagerData = fetchStaffviaID($projectData->_kf_staff_creativeManager_PROJECT); ?>							      
<p><strong>Creative Manager</strong><br><?php printf('<a href="mailto:%s?subject=%s&cc=%s">%s <i class="fa fa-envelope-o"></i></a>',$creativeManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$creativeManagerData->name_STAFF); ?></p><?php } ?>

<?php if($projectData->_kf_staff_editor_PROJECT) { $editorData = fetchStaffviaID($projectData->_kf_staff_editor_PROJECT); ?>	
<p><strong>Editor</strong><br><?php printf('<a href="mailto:%s?subject=%s&cc=%s">%s <i class="fa fa-envelope-o"></i></a>',$editorData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$editorData->name_STAFF); ?></p><?php } ?>
      
      
      </div>
      
      <div class="clearboth"></div>
      
      <!-- !BRIEF SIGN OFF -->

<div class="span12"><hr></div>

    <?php if (!empty($projectData->_kf_staff_brief_PROJECT) && !empty($projectData->_completed_brief_PROJECT)) { 
	      
	    $approvalData = fetchStaffviaID($projectData->_kf_staff_brief_PROJECT);
	      
      ?>

<div class="span12">
      <h5 class="sub-title">Brief Completed By <?php print $approvalData->name_STAFF; ?> on <?php print $projectData->completed_brief_PROJECT; ?></h5>

      </div>
      <div class="clearboth"></div><? } ?>
      

      
	</div>
	</div> <!-- /Brief INFO -->
	
	<?php } ?>
	


<?php include ('footer.php'); ?>
