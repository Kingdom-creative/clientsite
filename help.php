
<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<?php

	$localPage="help";
	$_SESSION['returnPage'] = currentPageURL();
	
	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	//Then fetch the user record

	$client = fetchClientData("username_CLIENT",$_SESSION['username']); ?>


<?php include ('head.php'); ?>



    
<! Containers >
<div id="container-fluid">
     <div class="row-fluid">
	     	<div class="span12">
	     	
<? include ('sidebar.php'); ?>


<div id="header-side-dash"><i class="icon-hdd"></i> Click on <i class="icon-angle-down"></i> to view each help topic<br>

<div class="tab-added"><a href="<?php echo $client->username_CLIENT; ?>/projects"><i class="icon-hdd"></i> <u>View completed projects</u></a><br><a href="<?php echo $client->username_CLIENT; ?>/home"><i class="icon-hdd"></i> <u>View active projects</u></a><br>
<i class="icon-hdd"></i> <a href="<?php echo $client->username_CLIENT; ?>/logout"><u>Logout</u></a>
</div>
</div>
<div class="clearboth"></div>

<div class="accordion-group">
<div class="accordion-heading-orange"><i class="icon-folder-close"></i>Help Topic<span style="float: right" class="date-added">Date Added</span></div></div>


<div class="accordion" id="accordion1"><! Needs to increase by 1 >
<div class="accordion-group">

<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse1"><! Needs to increase by #accordion1 and #collapse1 >
<i class="icon-angle-down"></i>Client Site Introduction<span class="date-added">10 May 2013</span></a></div>

<div id="collapse1"  class="accordion-body collapse"><! Match #collapse1 >
<div class="accordion-inner">
<div class="span12">
<div class="videoWrapper">
<iframe src="http://player.vimeo.com/video/65908344" width="890" height="501" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>
</div>
</div>
</div>

<div class="accordion" id="accordion2"><! Needs to increase by 1 >
<div class="accordion-group">

<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2"><! Needs to increase by #accordion1 and #collapse1 >
<i class="icon-angle-down"></i>Video Formats<span class="date-added">10 May 2013</span></a></div>
<? if($_GET['page'] == "video-formats") { ?>
<div id="collapse2"  class="accordion-body collapse in"><! Match #collapse1 >
<? } else { ?>
<div id="collapse2"  class="accordion-body collapse"><! Match #collapse1 >
<? } ?>
<div class="accordion-inner">
<div class="span12">

<? if($_GET['page'] == "video-formats") { ?>
<div class="videoWrapper">
<iframe src="http://player.vimeo.com/video/65908874?autoplay=1" width="890" height="501" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>
<? } else { ?>
<div class="videoWrapper">
<iframe src="http://player.vimeo.com/video/65908874" width="890" height="501" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>
<? } ?>
</div>
</div>
</div>


</div><! row fluid !>
  </div><! containter fluid !>
  
  </body>
</html>
