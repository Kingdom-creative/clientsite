
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

			

    
<div class="container">
     <div class="row">


<!-- <div id="loading"><div class="hide-resp">Welcome <? echo $client->name_CLIENT; ?>. </div>Loading your dashboard data.. <img src="images/loader.gif" width="20" height="20"></div> -->

      <div class="col-md-12">
      <ul class="project-list">
      
<?php $counter = 1; 
	
	$activeProjects = fetchActiveProjectData($client->_kp_CLIENT);
	
?>

<?php while( $projectData = $activeProjects->fetch_object()) { ?>

<! Loop code >
<li><a href="#"><div class="row"><div class="col-md-8"><p class="list-text"><i class="fa fa-folder-o"></i><? echo $projectData->title_PROJECT; ?></p></div><div class="col-md-2"><p class="list-info"><?php echo $projectData->approval_PROJECT; ?></p></div><div class="col-md-2"><a class="btn btn-primary">View Project</a></div></div></a></li>
<! END Loop code >

<? $counter++; ?>

<? } /*END WHILE PROJECT */ ?>



     </ul> 
       
      </div> <!-- /COL-MD-12 -->
  

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
