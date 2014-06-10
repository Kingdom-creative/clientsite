
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

<! Override for accordian margin. To make sure it doesnt affect other pages !>
<style>

.accordion {
    margin-bottom: 0px !important;
}
</style>

<! Containers >
<div id="container-fluid">
     <div class="row-fluid">
    <div class="span12">
  
<? include ('sidebar.php'); ?>


<div id="header-side-dash"><i class="icon-search"></i> Results for: "<? echo $_SESSION['searchstring']; ?>"</div>

<div id="header-side-dash-right">

<a href="https://twitter.com/CircuitPro_live" target="_blank"><img src="http://www.circuitpro.co.uk/wp-content/uploads/2013/02/twitter_normal.png"></a>&nbsp;<a href="http://www.facebook.com/pages/Circuit-Pro/299586280152318" target="_blank"><img src="http://www.circuitpro.co.uk/images/facebook_normal.png"></a></div>

<div class="clearboth"></div>

<!-- See if search string is empty and also if no results are found then display error page -->

<? if (!searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],"","")) { ?>

<h2 class="no-results">No results found<h2>

<p class="search-again"><a href="<? echo $client->username_CLIENT; ?>/projects">Search again?</a></p>

<form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return formVerify();">
    
    <input class="text-field" name="searchstring" type="text"  placeholder="Search content"/>
<p class="type-enter">Type in your search term & press enter</p>
</form>

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

<div class="accordion-group">
<div class="accordion-heading-orange"><i class="icon-folder-close"></i>Project - Film<span style="float: right">Date Added</span></div></div>




<?php while( $itemData = $foundResults->fetch_object()) { 

$title_VIDEO = str_replace(' -','',$itemData->title_VIDEO);

$title_VIDEO = preg_replace("/[^a-zA-Z0-9s]/", "-", $title_VIDEO); ?>

<div class="accordion" id="accordion<? echo $counter; ?>">
  <div class="accordion-group">
<div class="accordion-heading">
<a class="accordion-toggle" data-parent="#accordion<? echo $counter; ?>" href="<? echo $client->username_CLIENT; ?>/film/<?php echo $itemData->_kp_VIDEO;?>/<?php echo $title_VIDEO; ?>">
<i class="icon-eye-open"></i> <? echo $itemData->title_PROJECT; ?> - <? echo $itemData->title_VIDEO; ?>
<span class="date-added"> <?php echo $itemData->added_VIDEO;?></span>
</a>

</div>
</div>
</div>

<div class="clearboth"></div>

<? $counter++; ?>

<? }  } /*END WHILE PROJECT  END IF */ ?>


</div>

<? if (searchFilms($client->_kp_CLIENT,$_SESSION['searchstring'],"","")) { ?>

<ul class="pagebar">
 <li>Page&nbsp;</li>
    
      <?php $totalPages = ceil((fetchSearchCount($client->_kp_CLIENT,$_SESSION['searchstring'])) / PROJECT_RESULTS_PER_PAGE);
	 
	 $pageIndex = 1;
	 
	 while ($pageIndex <= $totalPages) {
     
     if($pageIndex == $pageNum) { ?>
      <li class="active"><?php echo $pageIndex; ?></li>
      <?php } else { ?>
      <li><a href="<? echo $_SESSION['username']; ?>/search/page-<?php echo $pageIndex; ?>"><?php echo $pageIndex; ?></a></li>
      <?php 
         }		
		$pageIndex++; 
	 }
  ?>
      
</ul>

<? } ?>


</div><!-- END Container-->


	</div><!-- /promoted -->

    <!-- end .content -->
  </div>
  
  </body>
</html>
