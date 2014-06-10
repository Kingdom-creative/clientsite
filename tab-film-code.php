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
