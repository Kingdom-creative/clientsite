

<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<? 
	
	/* Need to load up vars before loading head */
	$videoData = fetchFilm($_GET['film']); 
	
	$localPage = $videoData->title_VIDEO;
	$_SESSION['returnPage'] = currentPageURL();
	
	$client = fetchClientData("username_CLIENT",$_SESSION['username']);
	
?>

<?php include ('head.php'); ?>


<?php

	
	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	//Then fetch the user record

	$client = fetchClientData("username_CLIENT",$_SESSION['username']); 
	
	
?>


<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>

<div class="downloaded"><div class="dw-yes"><span class="btn btn-primary">Your file is now downloading...</span></div></div>

<! Containers >
<div class="container">
     <div class="row">
     
     <div class="span8 title">
      <h2><span class="op-title">Film</span><br><?php echo $videoData->title_VIDEO; ?></h2>
      <h5 class="sub-title">In the <a href="<?php echo '/client/'.$client->username_CLIENT.'/project/'.$videoData->_kp_PROJECT.'/'.titleURL($videoData->title_PROJECT); ?>"><? echo $videoData->title_PROJECT; ?> Project</a></h5>
      <p class="video-info-single">
      
      <!-- Timestamp --> <span class="time"><? echo time_elapsed_string($videoData->_added_VIDEO); ?></span>
      <!-- Version --> <?php if($videoData->version_VIDEO > 0) { echo '<span class="version">Version '.$videoData->version_VIDEO.'</span>'; } ?> 
      <!-- Password --> <span class="password"><?php if($videoData->password_VIDEO): ?><? echo 'Preview Password: '.$videoData->password_VIDEO; ?><?php else: ?><? endif; ?></span>
      </p>
      
      </div>
      
      <div class="span4 title align-right">
      <a class="btn btn-default" href="<?php echo '/client/'.$client->username_CLIENT.'/project/'.$videoData->_kp_PROJECT.'/'.titleURL($videoData->title_PROJECT); ?>" >Back to project</a>
    

</div>
     </div>
      
     </div>
     
</div>

<div class="clearboth"></div> 

<div class="container" id="sharelink-single">
<div class="row">
<div class="span12">
<input type="text" value="http://kingdom-creative.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>" class="form-control" id="shareLink-1" onClick="SelectAll('shareLink-1')"> 
     
     <?php if($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO || $videoData->link_iPhone_VIDEO || $videoData->link_other_VIDEO) { ?>
     <div class="btn-group">
  <a class="btn btn-primary" data-toggle="dropdown" href="#"><i class="fa fa-download"></i> Download</a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down"></span></a>
  <ul class="dropdown-menu">
  
    <?php //See if there is a download Subfolder
  		if(!empty($videoData->folder_PROJECT)) { $folder = $client->folder_CLIENT.'/'.$videoData->folder_PROJECT; } else { $folder = $client->folder_CLIENT; }  ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_QT_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/QT"><i class="fa fa-download fa-fw"></i> Quicktime</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_WMV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/WMV"><i class="fa fa-download fa-fw"></i> Windows Media</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_FLV_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/FLV"><i class="fa fa-download fa-fw"></i> Flash FLV</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_iPhone_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/iPhone"><i class="fa fa-download fa-fw"></i> iPhone</a></li>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_other_VIDEO,$folder))) { ?>
<li><a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/Other"><i class="fa fa-download fa-fw"></i> <? echo $videoData->link_otherLabel_VIDEO; ?></a></li>
<? } ?>

  </ul>
</div>

 <?php } else { ?>
 	<span class="downloads-un">No downloads</span>
 <?php } ?>
 
 
 
 
</div>
</div>
</div>

<div class="clearboth"></div>

<div class="container" id="single-film">
<div class="row">
	     	<div class="span12">
	     	

<div class="videoWrapper">
<? if($videoData->youtubeID_VIDEO) { ?>
<iframe width="931" height="557" src="//www.youtube.com/embed/<? echo $videoData->youtubeID_VIDEO; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
<? } else { ?>

<?php if ($_GET['action'] == "play") { ?>
<iframe width="931" height="524" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="http://player.vimeo.com/video/<? echo $videoData->vimeoID_VIDEO?>?autoplay=1"></iframe><?php } else { ?>
<iframe width="931" height="524" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="http://player.vimeo.com/video/<? echo $videoData->vimeoID_VIDEO?>"></iframe><?php } ?>
<div class="border"></div>
<?php } ?>
 
</div>
</div>
</div>










</div>

</div><!-- END -->

	</div><!--  -->

    <!-- end .content -->
  </div>
  
<?php include ('footer.php'); ?>
