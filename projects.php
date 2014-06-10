
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

<style>
.nav-pills > li:nth-child(2) > a{
	border: 1px solid #fff;
}
</style>

 <div class="container">
      <!-- Example row of columns -->
      <div class="row">

<div class="span7 title">
      <h2><? echo $client->name_CLIENT; ?><br><span class="op-title">View Completed Projects</span></h2>
      </div>
      
<div class="span5 title-search">
<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return searchVerify();" class="form-inline align-right hidden-xs">
	      <input class="form-control" name="searchstring" type="text"  placeholder="Search content" />
	      <input class="btn btn-primary" name="submit" type="submit"  value="Search" />
	     
	  </form>
</div>
      
      </div>
 </div>
 
 
 <!-- COMPLETED PROJECTS -->
 
  <div class="container" id="active-projects">
      <!-- Example row of columns -->
      <div class="row">
      

      
      <ul class="project-list">
      
<?php $counter = 1; 
	
	
	if($pageNum > 1) {
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,$currPage,$pageLimit); } else {
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,"","");	
	}
	
	$completedProjects = fetchCompletedProjectData($client->_kp_CLIENT,$currPage,$pageLimit);
	$counter = 1;
	
?>

<?php while( $projectData = $completedProjects->fetch_object()) { ?>
      <!-- LOOP -->
      <li><a href="<? echo $client->username_CLIENT; ?>/project/<? echo $projectData->_kp_PROJECT; ?>/<? echo titleURL($projectData->title_PROJECT); ?>">
      <!-- Project title --> <div class="span7 text"><p class="list-text"><i class="fa fa-folder"></i><? echo $projectData->title_PROJECT; ?></p></div>
      <!-- Extra info --> <div class="span2 added"><p><? if($projectData->youtubeStats_PROJECT) { ?>
<? $projectViews = getProjectYoutubeViewCount($projectData->_kp_PROJECT); ?>
<span class="views youtube-text"><? echo number_format($projectViews->viewsTotal_PROJECT); ?> views <i class="fa fa-youtube"></i></span><? } ?>
&nbsp;
</p></div>
      <!-- Approval & Stats --> <div class="span2 info"><p class="list-info"><? echo time_elapsed_string($projectData->_added_PROJECT); ?></p></div>
      <!-- Project link -->  <div class="span1 cta">View</div>
      <div class="clearboth"></div>
      </a></li>
      <!-- END LOOP -->
      
      
      <? } /* END WHILE FILM */ ?>
      
      </ul> 
      
      

      </div> <!-- /ROW -->
    </div> <!-- /CONTAINER -->
    
 <div class="container">
 
  <div class="row">
    <div class="pagination">
    <ul>
    
     <?php $totalPages = ceil((fetchProjectCount($client->_kp_CLIENT,"Completed")) / PROJECT_RESULTS_PER_PAGE);
	 
	 $pageIndex = 1;
	 
	 while ($pageIndex <= $totalPages) {
     
     if($pageIndex == $pageNum) { ?>
      <li class="disabled"><a href=""><?php echo $pageIndex; ?></a></li>
      <?php } else { ?>
      <li><a href="<? echo $_SESSION['username']; ?>/projects/page-<?php echo $pageIndex; ?>"><?php echo $pageIndex; ?></a></li>
      <?php 
         }		
		$pageIndex++; 
	 }
  ?>
     
</ul>
  </div>
  </div>

 </div>
  
<?php include ('footer.php'); ?>
