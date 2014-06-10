
<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<?php

	$localPage="home";
	$_SESSION['returnPage'] = currentPageURL();
	
	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	//Then fetch the user record

	$client = fetchClientData("username_CLIENT",$_SESSION['username']); ?>




<?php include ('head.php'); ?>

			

    
<! Containers >
<? include ('sidebar.php'); ?>
<div id="container-fluid">
     <div class="row-fluid">
	     	<div class="span12">


<div id="header-side-dash"><i class="icon-info-sign"></i> Click on <i class="icon-angle-down"></i> to view each project<br>
<div class="tab-added"><a href="<?php echo $client->username_CLIENT; ?>/projects"><i class="icon-hdd"></i> <u>View completed projects</u></a><br>
<i class="icon-hdd"></i> <a href="<?php echo $client->username_CLIENT; ?>/logout"><u>Logout</u></a>
</div>

</div>



<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").fadeToggle();  
})  
</script>
<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>


<div id="loading"><div class="hide-resp">Welcome <? echo $client->name_CLIENT; ?>. </div>Loading your dashboard data.. <img src="images/loader.gif" width="20" height="20"></div>

<div class="clearboth"></div>
<div class="accordion-group">
<div class="accordion-heading-orange"><i class="icon-folder-close"></i>Active Projects<span style="float: right" class="hide-resp">Date Added</span></div></div>

<?php $counter = 1; 
	
	$activeProjects = fetchActiveProjectData($client->_kp_CLIENT);
	
?>

<?php while( $projectData = $activeProjects->fetch_object()) { ?>

<! Loop code >
<div class="accordion" id="accordion<? echo $counter; ?>"><! Needs to increase by 1 >
<div class="accordion-group">

<!-- PROJECT TITLE -->
<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<? echo $counter; ?>" href="#collapse<? echo $counter; ?>"><! Needs to increase by #accordion1 and #collapse1 >
<i class="icon-angle-down"></i> <? echo $projectData->title_PROJECT; ?><? if($projectData->clientApproval_PROJECT == "Awaiting Approval") { ?>
<span class="views"> Brief Awaiting Approval <i class="icon-exclamation-sign"></i></span><? } ?>

<! Show Youtube stats if available !>
<? if($projectData->youtubeStats_PROJECT) { ?>
<? $projectViews = getProjectYoutubeViewCount($projectData->_kp_PROJECT); ?>
<span class="views"><i class="icon-desktop"></i><? echo number_format($projectViews->viewsTotal_PROJECT); ?> views</span><? } ?>

 <span class="date-added"><?php echo $projectData->added_PROJECT;?></span></a></div>
 
<!--  PROJECT DETAIL -->
<div id="collapse<? echo $counter; ?>"  class="accordion-body collapse"><! Match #collapse1 >
<div class="accordion-inner">
<p class="tab-added smalls">Date Added: <?php echo $projectData->added_PROJECT;?> l <? if($projectData->clientApproval_PROJECT == "Awaiting Approval") { ?>Brief Awaiting Approval <i class="icon-exclamation-sign"></i><div class="hide-resp"></div><? } ?></p>
<div class="span12">
<div class="span4" id="first-span"><h4><i class="icon-calendar pull-left icon-2x"></i>First Edit Delivered</h4>
<h2 class="time"><?php echo $projectData->firstDelivery_PROJECT; ?></h2></div><div class="span4" id="second-span"><h4><i class="icon-calendar pull-left icon-2x"></i>Feedback & Approval</h4><h2 class="time"><?php echo $projectData->approval_PROJECT; ?></h2></div><div class="span4" id="third-span"><h4><i class="icon-calendar pull-left icon-2x"></i>Final Edit Delivered</h4><h2 class="time"><?php echo $projectData->finalDelivery_PROJECT; ?></h2></div>
<div class="clearboth"></div>

<hr>

<? $videoCounter = 1; 
	
	$videoResult = fetchProjectVideos($projectData->_kp_PROJECT);
	
?>

<? while ($videoData = $videoResult->fetch_object()) {
	 

	$title_VIDEO = str_replace(' -','',$videoData->title_VIDEO);

	$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $title_VIDEO);  ?>

<div class="span12 first-span-people">

<a href="<? echo $client->username_CLIENT; ?>/film/<?php echo $videoData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>" ><span class="watch">View</span> <? echo $videoData->title_VIDEO; ?> <i class="icon-play-circle"></i><?php if($videoData->version_VIDEO > 1) { echo '<span class="views">Version: '.$videoData->version_VIDEO.' </span>'; } ?></a>

</div>


<? } /* END WHILE FILM */ ?>
<div class="clearboth"></div>
<hr>

   <div class="tabbable tabs-left">
							  <ul class="nav nav-tabs span3">
							    <li class="active"><a href="#tabs<? echo $counter; ?>-pane1" data-toggle="tab"><i class="icon-tasks"></i><div class="hide-resp">Aims</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane2" data-toggle="tab"><i class="icon-picture"></i><div class="hide-resp">Graphics</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane3" data-toggle="tab"><i class="icon-time"></i><div class="hide-resp">Duration</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane4" data-toggle="tab"><i class="icon-exchange"></i><div class="hide-resp">Distribution</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane5" data-toggle="tab"><i class="icon-download-alt"></i><div class="hide-resp">Formats</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane6" data-toggle="tab"><i class="icon-pencil"></i> <div class="hide-resp">Notes</div></a></li>
							    <li><a href="#tabs<? echo $counter; ?>-pane7" data-toggle="tab"><i class="icon-user"></i> <div class="hide-resp">Staff</div></a></li>
							  </ul>
							  <div class="tab-content brief span9">
							    <div id="tabs<? echo $counter; ?>-pane1" class="tab-pane active">
							      <h4>What do you want to achieve with the project?</h4>
				     							      <p><?php echo nl2br($projectData->check1_achieve_PROJECT); ?></p>
							    </div>
							    
							    <div id="tabs<? echo $counter; ?>-pane2" class="tab-pane">
							    <h4>What graphics appear during the film(s)?</h4>
							      <p><?php echo nl2br($projectData->check5_graphics_PROJECT); ?></p>
							    </div>
							    <div id="tabs<? echo $counter; ?>-pane3" class="tab-pane">
							      <h4>What duration are the film(s) going to be?</h4>
							     <p><?php echo nl2br($projectData->check4_duration_PROJECT); ?></p>
							    </div>
							    <div id="tabs<? echo $counter; ?>-pane4" class="tab-pane">
							      <h4>How/where will the film(s) be viewed?</h4>
							      <p><?php echo nl2br($projectData->check2_platform_PROJECT); ?></p>
							    </div>
							    
							     <div id="tabs<? echo $counter; ?>-pane5" class="tab-pane">
							      <h4>What video format do you need the film(s) to be in?</h4>
							      <p><?php echo nl2br($projectData->check3_format_PROJECT); ?></p>							    </div>
							    
							     <div id="tabs<? echo $counter; ?>-pane6" class="tab-pane">
							      <h4>Any additional points to note?</h4>
							      <p><?php echo nl2br($projectData->notes_ext_PROJECT); ?></p>
							    </div>
							    
							    <div id="tabs<? echo $counter; ?>-pane7" class="tab-pane">
							      <h4>Team Involved</h4>
							      
							      <?php $prodManagerData = fetchStaffviaID($projectData->_kf_staff_prodManager_PROJECT); ?>
							      <?php $creativeManagerData = fetchStaffviaID($projectData->_kf_staff_creativeManager_PROJECT); ?>
							      <?php $editorData = fetchStaffviaID($projectData->_kf_staff_editor_PROJECT); ?>
							      
							      <p><strong>Production Manager</strong><br><?php printf('<a href="mailto:%s?subject=%s">%s (Email me)</a>',$prodManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->name_STAFF); ?></p>
<p><strong>Creative Manager</strong><br><?php printf('<a href="mailto:%s?subject=%s&cc=%s">%s (Email me)</a>',$creativeManagerData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$creativeManagerData->name_STAFF); ?></p>
<p><strong>Editor</strong><br><?php printf('<a href="mailto:%s?subject=%s&cc=%s">%s (Email me)</a>',$editorData->email_STAFF,$projectData->title_PROJECT,$prodManagerData->email_STAFF,$editorData->name_STAFF); ?></p>

							    </div>
							  </div><!-- /.tab-content -->
							</div><!-- /.tabbable -->
</div>
<div class="clearboth"></div>
<hr>

<!-- BRIEF APPROVAL -->
<? if($projectData->clientApproval_PROJECT == "Awaiting Approval") { ?>
<div id="approval">
<form id="clientApproval" action="http://server.circuitpro.co.uk/client-support/approveBrief.php" method="post" enctype="multipart/form-data">
    <textarea name="briefNotes" id="briefNotes" placeholder="Add notes to brief"></textarea>
    <input name="projectID" type="hidden"  value="<? echo $projectData->_kp_PROJECT; ?>" />
    <input name="projectTitle" type="hidden"  value="<? echo $projectData->title_PROJECT; ?>" />
    <input name="projectProdMgr" type="hidden"  value="<? echo $prodManagerData->email_STAFF; ?>" />
    <button name="approveBriefSubmit" type="submit"  class="btn btn-inverse form-sub" id="submitButton"/><i class="icon-check-sign"></i> Approve Brief</button>
</form>
</div>
<div class="welldone alert alert-success"><strong>Success!</strong> Brief approval submitted</div>
<script type="text/javascript">
    var frm = $('#clientApproval');
    frm.submit(function () {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                alert("Brief Approval Submitted");
            }
        });

        return false;
    });
   
   $(".form-sub").click(function () {
$(".welldone").fadeToggle();
$("#approval").fadeToggle();
});
  
</script>

<? } ?>


</div>
</div>
</div>
<! END Loop code >

<? $counter++; ?>

<? } /*END WHILE PROJECT */ ?>



</div>


</div>

	</div>

  </div>
  
 
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="header">
      <div class="container">
      <div class="row">
      <div class="col-md-2">
      <img src="img/kingdom-full-tertiary.svg">
      </div>
      
       <div class="col-md-10 right-cl">
<ul class="nav nav-pills navbar-right"><li><a href="#">Home</a></li><li class="active"><a href="#">Active Projects</a></li><li><a href="#">Completed Projects</a></li><li><a href="#">Help</a></li><li><a href="#">Logout</a></li></ul>
      </div>
      
      </div>
      </div>
    </div> <!-- /HEADER -->

    <div class="container" id="active-projects">
      <!-- Example row of columns -->
      <div class="row">
      
      <div class="col-md-12 title">
      <h2>Hello Toby!</h2>
      </div>
      
      <div class="clearboth"></div>
      
      <div class="col-md-8">
      <h3 class="list-sub"><i class="fa fa-folder-o primary-text"></i> Active Projects</h3>
      <h5 class="sub-title">View all projects currently in progress</h5>
      </div>
      
      <div class="col-md-4">
      <input class="form-control" placeholder="Search Content">
      </div>
      
      <div class="clearboth"></div>
      
      <div class="col-md-12">
      <ul class="project-list">
      
      <li><a href="#"><div class="row"><div class="col-md-8"><p class="list-text"><i class="fa fa-folder-o"></i>PDS Masterpieces 2014</p></div><div class="col-md-2"><p class="list-info">Brief Awaiting Approval</p></div><div class="col-md-2"><a class="btn btn-primary">View Project</a></div></div></a></li>
      <li><a href="#"><div class="row"><div class="col-md-8"><p class="list-text"><i class="fa fa-folder-o"></i>Porsche ECM off-site meeting</p></div><div class="col-md-2"><p class="list-info">Brief Awaiting Approval</p></div><div class="col-md-2"><a class="btn btn-primary">View Project</a></div></div></a></li>
      <li><a href="#"><div class="row"><div class="col-md-8"><p class="list-text"><i class="fa fa-folder-o"></i>Get Race Fit 2014</p></div><div class="col-md-2"><p class="list-info">Brief Awaiting Approval</p></div><div class="col-md-2"><a class="btn btn-primary">View Project</a></div></div></a></li>
      <li><a href="#"><div class="row"><div class="col-md-8"><p class="list-text"><i class="fa fa-folder-o"></i>Le Mans Driver Films 2013</p></div><div class="col-md-2"><p class="list-info">Brief Awaiting Approval</p></div><div class="col-md-2"><a class="btn btn-primary">View Project</a></div></div></a></li>
      
      </ul> 
       
      </div> <!-- /COL-MD-12 -->
      
      <div class="col-md-12 completed-action">
      <a class="btn btn-dark">View all completed projects</a>
      </div>
      
      
      
        
      </div> <!-- /ROW -->
    </div> <!-- /CONTAINER -->


  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>

    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/scripts.js"></script>
    <script src="js/plugins.js"></script> 
  
  
  </body>
</html>
