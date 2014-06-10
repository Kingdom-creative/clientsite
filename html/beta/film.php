

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

<?php include ('head.php'); ?>

<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>

<! Containers >
<div id="container-fluid">
     <div class="row-fluid">
	     	<div class="span12">
	     	
<? include ('sidebar.php'); ?>


<div id="header-side-dash"><i class="icon-hdd"></i> View and download your film&nbsp; l &nbsp;<a href="#" onclick="history.back(); return false;" style="color: #fff !important;">Back to projects</a></div>

<div id="header-side-dash-right"><a href="https://twitter.com/CircuitPro_live" target="_blank"><img src="http://www.circuitpro.co.uk/wp-content/uploads/2013/02/twitter_normal.png"></a>&nbsp;<a href="http://www.facebook.com/pages/Circuit-Pro/299586280152318" target="_blank"><img src="http://www.circuitpro.co.uk/images/facebook_normal.png"></a></div>

<div class="clearboth"></div>

<div class="accordion-group">
<div class="accordion-heading-orange"><i class="icon-folder-close"></i>Video<span class="hide-resp" style="float: right">Date Added</span></div></div>


<div class="accordion" id="accordion1"><! Needs to increase by 1 >
<div class="accordion-group">

<div class="accordion-heading">
<a class="accordion-toggle"  data-parent="#accordion1" ><! Needs to increase by #accordion1 and #collapse1 >
<i class="icon-angle-down"></i><? echo $videoData->title_PROJECT; ?> l <? echo $videoData->title_VIDEO; ?> <? if($videoData->password_VIDEO) { ?> <div class="vid-pass"><i class="icon-lock icon-large"></i> <? echo $videoData->password_VIDEO; ?></div><? } ?>
<?php if($videoData->version_VIDEO > 1) { echo '<span class="views">Version: '.$videoData->version_VIDEO.'</span>'; } ?>

<span class="date-added"><? echo $videoData->added_VIDEO; ?></span></a></div>



<div id="collapse1"  class="accordion-body"> <!-- ID COLLAPSE1 -->
<div class="accordion-inner">
<!-- VIDEO -->
<div class="span12">
<div class="videoWrapper">
<? if($videoData->youtubeID_VIDEO) { ?>
<iframe width="933" height="524" src="//www.youtube.com/embed/<? echo $videoData->youtubeID_VIDEO; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
<? } else { ?>
<iframe width="933" height="524" frameborder="0" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen="" src="http://player.vimeo.com/video/<? echo $videoData->vimeoID_VIDEO?>"></iframe>
<? } ?>
</div>
</div>
</div>

<div class="accordion-inner"> <!-- TABBLE DOWNLOAD -->
<div class="span12">

<div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs">
    <li class="active hide-resp"><a href="#<? echo $videoData->_kp_VIDEO; ?>-tab1" data-toggle="tab"><i class="icon-download"></i> Download</a></li>
    <? if(empty($videoData->password_VIDEO)) {?>
    <li><a href="#<? echo $videoData->_kp_VIDEO; ?>-tab2" data-toggle="tab"><i class="icon-share"></i> Share</a></li>
    <? } ?>
    <? if($videoData->youtubeID_VIDEO && $videoData->youtubeStats_PROJECT) {?>
    <li><a href="#<? echo $videoData->_kp_VIDEO; ?>-tab3" data-toggle="tab"><i class="icon-desktop"></i> YouTube Stats</a></li>
    <? } ?>
    <li><a href="#<? echo $videoData->_kp_VIDEO; ?>-tab4" data-toggle="tab"><i class="icon-question-sign"></i> Help</a></li>
    </ul>
    
    <div class="tab-content">
    <div class="tab-pane active" id="<? echo $videoData->_kp_VIDEO; ?>-tab1">
    <div id="download" class="downloads"><div class="hide-resp">
    
   <?php if($videoData->link_QT_VIDEO || $videoData->link_WMV_VIDEO || $videoData->link_FLV_VIDEO || $videoData->link_iPhone_VIDEO || $videoData->link_other_VIDEO) { ?>


<? if(fileDownloadCheck(fileDownloadURL($videoData->link_QT_VIDEO,$client->folder_CLIENT))) { ?>
<a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/QT" class="btn btn-primary"><i class="icon-arrow-down"></i> Quicktime</button></a>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_WMV_VIDEO,$client->folder_CLIENT))) { ?>
<a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/WMV" class="btn btn-success"><i class="icon-arrow-down"></i> Windows Media</button></a>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_FLV_VIDEO,$client->folder_CLIENT))) { ?>
<a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/FLV" class="btn btn-warning"><i class="icon-arrow-down"></i> Flash FLV</button></a>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_iPhone_VIDEO,$client->folder_CLIENT))) { ?>
<a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/iPhone" class="btn btn-info"><i class="icon-arrow-down"></i> iPhone</button></a>
<? } ?>

<? if(fileDownloadCheck(fileDownloadURL($videoData->link_other_VIDEO,$client->folder_CLIENT))) { ?>
<a href="<? echo $client->username_CLIENT; ?>/download/<? echo $videoData->_kp_VIDEO; ?>/Other" class="btn btn-info"><i class="icon-arrow-down"></i> <? echo $videoData->link_otherLabel_VIDEO; ?></button></a>
<? } ?>

 <?php } else { ?><i><i class="icon-exclamation-sign"></i> No downloads available</i>
 
 <?php } ?>
</div>
    </div><!-- Downloads -->
    
    
</div>

    <div class="tab-pane" id="<? echo $videoData->_kp_VIDEO; ?>-tab2">
	   <p class="downloads"><input type="text" value="http://circuitpro.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>" class="input-link" id="shareLink" onClick="SelectAll('shareLink')">
	   <a  class="btn btn-warning" href="mailto:?Subject=<? printf('View Film: %s - %s',$videoData->title_PROJECT,$videoData->title_VIDEO)?>&body=http://circuitpro.co.uk/view/share/<? echo $videoData->_kp_VIDEO; ?>">Send</a>
    </p>
    </div>

<?
							    
							    //Show Youtube Stats if applicable 
							    
							    	if($videoData->youtubeID_VIDEO && $videoData->youtubeStats_PROJECT) {
								    $video_ID = $videoData->youtubeID_VIDEO;
								    $JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_ID}?v=2&alt=json");
								    $JSON_Data = json_decode($JSON);
								    $views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};
								    $rating = $JSON_Data->{'entry'}->{'yt$rating'}->{'numLikes'}; 
								    
								    
								    //Write back current number of YouTube views into our database
								    
								    if($views) {
									    
									updateYoutubeViewCount($videoData->_kp_VIDEO,$views);
									    
								    } }
								    
								    
								    ?>
								    
								    
								   
								    
							      


   <div class="tab-pane" id="<? echo $videoData->_kp_VIDEO; ?>-tab3">
   <div class="helplink">
   <p class="downloads"><a href="http://www.youtube.com/watch?v=<? echo $videoData->youtubeID_VIDEO; ?>"><i class="icon-desktop"></i> Views: <strong><? echo number_format($views); ?></strong> l <i class="icon-thumbs-up"></i> Likes: <strong><? echo $rating; ?></strong></a></p></div>
   
   </div>
     


     <div class="tab-pane" id="<? echo $videoData->_kp_VIDEO; ?>-tab4">
    <div class="helplink">
<p class="downloads"><i><a href="<? echo $client->username_CLIENT; ?>/help/video-formats"><i class="icon-question-sign"></i> What format do I need?</a></i></p>

</div>
</div>


</div>
</div> <!-- END TABBLE DOWNLOAD -->


</div> <!-- END ID COLLAPSE1 -->




</div><! row fluid !>
  </div><! containter fluid !>








</div>

</div><!-- END -->

	</div><!--  -->

    <!-- end .content -->
  </div>
  
  </body>
</html>
