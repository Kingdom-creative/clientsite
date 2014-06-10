
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
.nav-pills > li:nth-child(2) > a{
	border: 1px solid #fff;
}
</style>

 <div class="container">
      <!-- Example row of columns -->
      <div class="row">

<div class="col-sm-6 col-md-8 title">
      <h2><span class="op-title"><? echo $client->name_CLIENT; ?></span><br>
      Active Projects</h2>
      </div>
      
<div class="col-sm-6 col-md-4 title">
<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return searchVerify();" class="form-inline align-right hidden-xs">
<div class="form-group">
	      <input class="form-control" name="searchstring" type="text"  placeholder="Search content" />
</div>
<div class="form-group">
	      <input class="btn btn-primary" name="submit" type="submit"  value="Search" />
	      </div>
	  </form>
</div>
      
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
      <!-- Project title --> <div class="col-xs-12 col-sm-9 col-md-6 col-lg-7 text"><p class="list-text"><i class="fa fa-folder-o hidden-xs"></i><? echo $projectData->title_PROJECT; ?></p></div>
      <!-- Extra info --> <div class="hidden-xs hidden-sm col-sm3 col-md-2 col-lg-2 added"><p><? if($projectData->youtubeStats_PROJECT) { ?>
<? $projectViews = getProjectYoutubeViewCount($projectData->_kp_PROJECT); ?>
<span class="views youtube-text"><? echo number_format($projectViews->viewsTotal_PROJECT); ?> views <i class="fa fa-youtube"></i></span><? } ?>
&nbsp;
</p></div>
      <!-- Approval & Stats --> <div class="hidden-xs hidden-sm col-sm-9 col-md-3 col-lg-2 info"><p class="list-info"><? if($projectData->clientApproval_PROJECT == "Awaiting Approval") { ?>Brief Awaiting Approval<? } ?></p></div>
      <!-- Project link -->  <div class="hidden-xs hidden-sm col-sm-3 col-md-1 col-lg-1 cta">View</div>
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
    
    <div class="col-md-12 completed-action">
      <a class="btn btn-dark" href="<?php echo $client->username_CLIENT; ?>/projects">View all completed projects</a>
      </div>
      
      </div>
    </div>


   <?php include ('footer.php'); ?>
