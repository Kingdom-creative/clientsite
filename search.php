
<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<?php

	$localPage="search results";
	$_SESSION['returnPage'] = currentPageURL();
	
	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
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
	
	//Set up variables for passing between pages
	
	if(!empty($_POST['searchstring'])) { $_SESSION['searchstring'] = $_POST['searchstring']; }
	
	
?>


<?php include ('head.php'); ?>

 <div class="container">
      <!-- Example row of columns -->
      <div class="row">

<div class="span7 title">
      <h2><span class="op-title">Search</span><br>
      Results containing "<? echo $_SESSION['searchstring']; ?>"</h2>
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
      

      

<? if (!searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],"","")) { ?>
<div class="span12">
<h2 class="no-results">No results found</h2>

<p class="search-again"><a href="<? echo $client->username_CLIENT; ?>/projects">Search again?</a></p>

<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return formVerify();">
    
    <input class="text-field" name="searchstring" type="text"  placeholder="Search content"/>
<p class="type-enter">Type in your search term & press enter</p>
</form>
</div>
<? } else {?>

<?php 

	$counter = 1; 
	
	if($pageNum > 1) {
	$foundResults = searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],$currPage,$pageLimit); } else {
	$foundResults = searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],"","");	
	}
	
	$foundResults = searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],$currPage,$pageLimit);
	$counter = 1;
	
?>

      <ul class="search-list">


<?php while( $itemData = $foundResults->fetch_object()) { 

$title_VIDEO = str_replace(' -','',$itemData->title_VIDEO);

$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $title_VIDEO); ?>

<!-- LOOP -->
      <li><a href="<? echo $client->username_CLIENT; ?>/film/<? echo $itemData->_kp_VIDEO; ?>/<? echo titleURL($itemData->title_VIDEO); ?>">
      <!-- Project title --> <div class="span7 text"><p class="list-text"><? echo $itemData->title_PROJECT; ?> <br><span class="project-search"><? echo $itemData->title_VIDEO; ?></span></p></div>
      <!-- Extra info --> <div class="span2 added"><p><? if($itemData->youtubeStats_PROJECT) { ?>

<span class="views youtube-text"><? echo number_format($itemData->youtubeViews_VIDEO); ?> views <i class="fa fa-youtube"></i></span><? } ?>
&nbsp;
</p></div>
      <!-- Approval & Stats --> <div class="span2 info"><p class="list-info"><? echo time_elapsed_string($itemData->_added_VIDEO); ?></p></div>
      <!-- Project link -->  <div class="span1 cta">View</div>
      <div class="clearboth"></div>
      </a></li>
      <!-- END LOOP -->


<? $counter++; ?>

<? }  } /*END WHILE PROJECT  END IF */ ?>

      </ul>

</div>
</div>
</div>

<div class="clearboth"></div>



</div>

<? if (searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],"","")) { ?>

 <div class="container">
 
  <div class="row">
<div class="pagination">
<ul>
    
      <?php $totalPages = ceil((fetchSearchCount($client->_kp_CLIENT,$_SESSION['searchstring'])) / PROJECT_RESULTS_PER_PAGE);
	 
	 $pageIndex = 1;
	 
	 while ($pageIndex <= $totalPages) {
     
     if($pageIndex == $pageNum) { ?>
      <li class="disabled"><a href=""><?php echo $pageIndex; ?></a></li>
      <?php } else { ?>
      <li><a href="<? echo $_SESSION['username']; ?>/search/page-<?php echo $pageIndex; ?>"><?php echo $pageIndex; ?></a></li>
      <?php 
         }		
		$pageIndex++; 
	 }
  ?>
      
</ul>

  </div>
 </div>
 </div>
<? } ?>


</div><!-- END Container-->


	</div><!-- /promoted -->

    <!-- end .content -->
  </div>
  
  </body>
</html>
