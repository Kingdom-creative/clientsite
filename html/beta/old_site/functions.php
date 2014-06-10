<?php 

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
			'SELECT * FROM staff WHERE type_STAFF = "%s"',$dbLink->real_escape_string($type));
				
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
		
function fileExists($path) {
    return (@fopen($path,"r")==true);  
	
	}
	
	
function fetchPromotedFilms() {
	
	 try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database (function: fetchPromotedFilms).');
		
      $dbFilmQuery = sprintf(
			'SELECT * FROM video LEFT JOIN project ON video._kf_project_VIDEO = project._kp_PROJECT where promoted_VIDEO = "YES" ORDER BY _added_VIDEO DESC');
				
		$dbFilmResult = $dbLink->query($dbFilmQuery);
		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for promoted film data');
		
		//User details not found in DB	
		   if( $dbFilmResult->num_rows == 0 )
				return false;
			
		return $dbFilmResult;
			
		
      }
      	catch(Exception $thisException)
		{
		include('/client/error.php'); 
		
		die;
		
		} 
		
		$dbStaffResult->close();
			$dbLink->close();
		
		}
		
?>