
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

<style>
.nav-pills > li:nth-child(1) > a{
	border: 1px solid #fff;
}
</style>

 <div class="container">
      <!-- Example row of columns -->
      <div class="row">

<div class="span7 title">
      <h2><span class="op-title"><? echo $client->name_CLIENT; ?></span><br>
      Active Projects</h2>
      </div>
      
<div class="span5 title-search">
<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return searchVerify();" class="form-inline align-right hidden-xs">
	      <input class="form-control" name="searchstring" type="text"  placeholder="Search content" />
	      <input class="btn btn-primary" name="submit" type="submit"  value="Search" />
	      </div>
	  </form>
      
      </div>
 </div>
      

    <div class="container" id="active-projects">
      <!-- Example row of columns -->
      <div class="row">
      
      
      <ul class="project-list">
      
      <?php $counter = 1; $activeProjects = fetchActiveProjectData($client->_kp_CLIENT); ?>

      <?php while( $projectData = $activeProjects->fetch_object()) { ?>
      <!-- LOOP -->
      <li><a href="<? echo $client->username_CLIENT; ?>/project/<? echo $projectData->_kp_PROJECT; ?>/<? echo titleURL($projectData->title_PROJECT); ?>">
      <!-- Project title --> <div class="span7 text"><p class="list-text"><i class="fa fa-folder-o hidden-xs"></i><? echo $projectData->title_PROJECT; ?></p></div>
      <!-- Extra info --> <div class="span2 added"><p><? if($projectData->youtubeStats_PROJECT) { ?>
<? $projectViews = getProjectYoutubeViewCount($projectData->_kp_PROJECT); ?>
<span class="views youtube-text"><? echo number_format($projectViews->viewsTotal_PROJECT); ?> views <i class="fa fa-youtube"></i></span><? } ?>
&nbsp;
</p></div>
      <!-- Approval & Stats --> <div class="span2 info"><p class="list-info"><? if (!empty($projectData->_kf_staff_brief_PROJECT) && !empty($projectData->_completed_brief_PROJECT)) { ?>Brief Completed<? } else { ?>Brief Awaiting Approval<? } ?></p></div>
      <!-- Project link -->  <div class="span1 cta">View</div>
      <div class="clearboth"></div>
      </a></li>
      <!-- END LOOP -->
      
      
      <? } /* END WHILE FILM */ ?>
      
      </ul> 

      </div> <!-- /ROW -->
    </div> <!-- /CONTAINER -->
    
    <div class="container">
      <!-- Example row of columns -->
      <div class="row"> 
    
    <div class="span12 completed-action">
      <a class="btn btn-dark" href="<?php echo $client->username_CLIENT; ?>/projects">View all completed projects</a>
      </div>
      
      </div>
    </div>


   <?php include ('footer.php'); ?>
