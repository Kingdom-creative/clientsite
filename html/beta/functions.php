<?php 


//--------------------- USER AND SESSION FUNCTIONS --------------------//

	if(!session_id()) {
     session_start();
     }
     
     ini_set('date.timezone','Europe/London');
     

function currentPageURL() {
 	$pageURL = 'http';
 	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
  	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
	}
	

function checkLoggedIn () {
	
	if ( isset($_SESSION['username'])) {
	
	return true; } else { return false; }
		
	}
	
	
function fetchClientData($field, $value) {
		 try {
		//Create link
		$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
			
		//Can't connect to DB
		if( mysqli_connect_errno() )
			throw new Exception('Could not connect to database (function: fetchUserRecord).');
			
	      $dbClientQuery = sprintf(
				'SELECT * FROM client WHERE %s = "%s"',$field,$dbLink->real_escape_string($value));
					
			$dbClientResult = $dbLink->query($dbClientQuery);
			
			//General Query error
			if( $dbLink->errno )
				throw new Exception('An error occurred when querying the database for user data');
			
			//User details not found in DB	
			   if( $dbClientResult->num_rows == 0 )
					return false;
				
			return $dbClientResult->fetch_object();
				
			
	      }
	      	catch(Exception $thisException)
			{
			include('error.php'); 
			die;
			
			} 
			
			$dbClientResult->close();
				$dbLink->close();
		
}


function clientLoginTimeStamp($kp_user) {

 try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (clientLoginTimeStamp).');
		
      $dbUserQuery = sprintf(
			'UPDATE client SET lastLogin_CLIENT = NOW() WHERE _kp_CLIENT = "%d"',$kp_user);
				
		$dbUserResult = $dbLink->query($dbUserQuery);
		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when updating login timestamp');
			
		return true;
		
      }
      	catch(Exception $thisException)
		{
		include('error.php'); 
		
		die;
		
		} 
		
		$dbUserResult->close();
			$dbLink->close();
		
	
}
		

function fetchActiveProjectData($clientID) {

		 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database.');
		
			$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT, DATE_FORMAT(date_firstDelivery_PROJECT, "%e %b %Y") AS firstDelivery_PROJECT, DATE_FORMAT(date_approval_PROJECT, "%e %b %Y") AS approval_PROJECT, DATE_FORMAT(date_finalDelivery_PROJECT, "%e %b %Y") AS finalDelivery_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$clientID.' AND live_PROJECT IS NOT NULL AND status_PROJECT = "Active" ORDER BY _added_PROJECT DESC';
				
				
				$dbResultProject = $dbLink->query($dbProjectQuery);
				
				$project_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
			        
				if (empty($project_found)) {
					
					header("Location: /client/".$_SESSION['username']."/projects");
					
				}
				
				return $dbResultProject;
				
		      }
		      	catch(Exception $thisException)
			{
				include('/client/error.php');
				die;
			}
}


function fetchCompletedProjectData($clientID,$page,$limit) {

		 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database.');
				
				if(empty($page)) { $page = 0; $limit = PROJECT_RESULTS_PER_PAGE; }
		
			$dbProjectQuery = 'SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(_added_PROJECT, "%e %b %Y") AS added_PROJECT, DATE_FORMAT(date_firstDelivery_PROJECT, "%e %b %Y") AS firstDelivery_PROJECT, DATE_FORMAT(date_approval_PROJECT, "%e %b %Y") AS approval_PROJECT, DATE_FORMAT(date_finalDelivery_PROJECT, "%e %b %Y") AS finalDelivery_PROJECT FROM project LEFT JOIN client ON project._kf_client_PROJECT = client._kp_CLIENT WHERE _kf_client_PROJECT = '.$clientID.' AND live_PROJECT IS NOT NULL AND status_PROJECT = "Completed" OR status_PROJECT = "Approved" ORDER BY _added_PROJECT DESC LIMIT '.$page.','.$limit;
				
				
				$dbResultProject = $dbLink->query($dbProjectQuery);
				
				$comp_project_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
			        
				if (empty($comp_project_found)) {
					
					header("Location: /client/".$_SESSION['username']."/home");
					
				}
				
				return $dbResultProject;
				
		      }
		      	catch(Exception $thisException)
			{
				include('/client/error.php');
				die;
			}
}


function fetchSearchCount($client,$string) {
	 try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (fetchStoryCount).');
		
		

		$dbSearchQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO,title_PROJECT from video LEFT JOIN project ON video._kf_project_VIDEO = project._kp_PROJECT WHERE project._kf_client_PROJECT = "'.$client.'" AND (title_VIDEO LIKE "%'.$dbLink->real_escape_string($string).'%" OR title_PROJECT LIKE "%'.$dbLink->real_escape_string($string).'%")  ORDER BY _added_VIDEO DESC';
		
		
		$dbResultCount = $dbLink->query($dbSearchQuery);
		
		$searchFound = $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;


		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for search content count');
		
		//User details not found in DB	
		   if( $searchFound == 0 ) {
			   
				return false; };
	
		return $searchFound;
		
      }
      	catch(Exception $thisException)
		{
	
		print($thisException->getMessage());
		
		} 
		
		$dbResultCount->close();
		$dbLink->close();
		
		}



function fetchProjectCount($value,$status) {
	 try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (fetchProjectCount).');
		
		

		$dbProjectCountQuery = 'SELECT _kp_PROJECT FROM project WHERE _kf_client_PROJECT = "'.$dbLink->real_escape_string($value).'" AND status_PROJECT = "'.$dbLink->real_escape_string($status).'"';
		
		
		$dbResultCount = $dbLink->query($dbProjectCountQuery);
		
		$projectFound = $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;


		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for project content count');
		
		//Project details not found in DB	
		   if( $projectFound == 0 ) {
			   
				return false; };
	
		return $projectFound;
		
      }
      	catch(Exception $thisException)
		{
	
		print($thisException->getMessage());
		
		} 
		
		$dbResultCount->close();
		$dbLink->close();
		
		}



function fetchProjectVideos($projectID) {

		 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database.');
		
			$dbVideoQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO from video WHERE _kf_project_VIDEO ="'.$projectID.'" ORDER BY _added_VIDEO DESC';
			$dbVideoResult = $dbLink->query($dbVideoQuery);
			
			$films_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;

				
			return $dbVideoResult;
				
		      }
		      	catch(Exception $thisException)
			{
				include('/client/error.php');
				die;
			}
}


function fetchFilm($filmID) {

		 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database.');
		
			$dbFilmQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO,title_PROJECT from video LEFT JOIN project ON video._kf_project_VIDEO = project._kp_PROJECT WHERE _kp_VIDEO ="'.$filmID.'"';
			$dbFilmResult = $dbLink->query($dbFilmQuery);
			
			$films_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;

			return $dbFilmResult->fetch_object();
				
		      }
		      	catch(Exception $thisException)
			{
				include('/client/error.php');
				die;
			}
}

function searchFilms($clientID,$string,$page,$limit) {

		 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database.');
				
			if(empty($page)) { $page = 0; $limit = PROJECT_RESULTS_PER_PAGE; }
		
			$dbSearchQuery = 'SELECT *, DATE_FORMAT(_added_VIDEO, "%e %b %Y") AS added_VIDEO,title_PROJECT from video LEFT JOIN project ON video._kf_project_VIDEO = project._kp_PROJECT WHERE project._kf_client_PROJECT = "'.$clientID.'" AND (title_VIDEO LIKE "%'.$dbLink->real_escape_string($string).'%" OR title_PROJECT LIKE "%'.$dbLink->real_escape_string($string).'%")  ORDER BY _added_VIDEO DESC LIMIT '.$page.','.$limit;
			
			$dbSearchResult = $dbLink->query($dbSearchQuery);
			
			$films_found =  $dbLink->query('SELECT FOUND_ROWS() AS found')->fetch_object()->found;
			
			if( $films_found == 0 ) {
			   
				return false; };
				
			return $dbSearchResult;
				
		      }
		      	catch(Exception $thisException)
			{
				include('/client/error.php');
				die;
			}
}

function updateYoutubeViewCount($filmID,$views) {
	
	try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (updateYoutubeViewCount).');
		
      $dbYTQuery = sprintf(
			'UPDATE video SET youtubeViews_VIDEO = "%d" WHERE _kp_VIDEO = "%d"',$views,$filmID);
				
		$dbYTResult = $dbLink->query($dbYTQuery);
		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when updating youtube view count');
			
		return true;
		
      }
      	catch(Exception $thisException)
		{
		include('error.php'); 
		
		die;
		
		} 
		
		$dbYTResult->close();
			$dbLink->close();
	
	
}

function getProjectYoutubeViewCount($projectID) {

	try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (updateYoutubeViewCount).');

	$dbCountQuery = 'SELECT SUM(youtubeViews_VIDEO) AS viewsTotal_PROJECT from video WHERE _kf_project_VIDEO ="'.$projectID.'"';
	
	$dbCountResult = $dbLink->query($dbCountQuery);
	
	return $dbCountResult->fetch_object();
	
	 }
      	catch(Exception $thisException)
		{
		include('error.php'); 
		
		die;
		
		} 
		
		$dbCountResult->close();
		$dbLink->close();


	}

function fetchStaffviaID($value) {
			
			if(! $value) { return "Not Assigned";  die;}
			
			 try {
			//Create link
			$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
				
			//Can't connect to DB
			if( mysqli_connect_errno() )
				throw new Exception('Could not connect to database (function: fetchStaffRecord).');
				
		      $dbStaffQuery = sprintf(
					'SELECT * FROM staff WHERE _kp_STAFF = %d',$dbLink->real_escape_string($value));
						
				$dbStaffResult = $dbLink->query($dbStaffQuery);
				
				//General Query error
				if( $dbLink->errno )
					throw new Exception('An error occurred when querying the database for staff data');
				
				//User details not found in DB	
				   if( $dbStaffResult->num_rows == 0 )
						return false;
					
				return $dbStaffResult->fetch_object();
					
				
		      }
		      	catch(Exception $thisException)
				{
				include('/client/error.php'); 
				die;
				
				} 
				
				$dbStaffResult->close();
					$dbLink->close();
				
		}
		

function fetchStaffviaType($type) {
	
	 try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (function: fetchStaffviaType).');
		
      $dbStaffQuery = sprintf(
			'SELECT * FROM staff WHERE type_STAFF LIKE "%%%s%%"',$dbLink->real_escape_string($type));
				
		$dbStaffResult = $dbLink->query($dbStaffQuery);
		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for staff data');
		
		//User details not found in DB	
		   if( $dbStaffResult->num_rows == 0 )
				return false;
			
		return $dbStaffResult;
			
		
      }
      	catch(Exception $thisException)
		{
		include('/client/error.php'); 
		die;
		
		} 
		
		$dbStaffResult->close();
			$dbLink->close();
		
		}
		
	

		
function fileDownloadURL ($filename,$folder) {
	

	 $file_name = rawurlencode($filename);
	 $file_path = 'http://content.circuitpro.co.uk/'.$folder.'/'.$file_name;
	 
				
	return $file_path; }
	
	
function fileDownloadCheck ($path) {
		 
	 return (@fopen($path,"r")==true);
	 
	 }

		
?>