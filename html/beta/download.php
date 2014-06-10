<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>

<?php
	
	//Check if client is logged in first
	if (!checkLoggedIn()) {
	header("Location: /client/error_login.php"); }
	
	//Then fetch the client record

	$client = fetchClientData("username_CLIENT",$_SESSION['username']); 



 try {


 //Check URL Vars
		
	if( empty($_GET['ref']))
		throw new Exception('File ID reference invalid');
		
	 if(  empty($_GET['format']))
		throw new Exception('File format not specified');
	
	//Get video data
		
	$videoData = fetchFilm($_GET['ref']);
	
	//Get the right format out
	
	switch ($_GET['format']) {
		
	case "QT": $filename = $videoData->link_QT_VIDEO; break;
	case "WMV": $filename = $videoData->link_WMV_VIDEO; break;
	case "FLV": $filename = $videoData->link_FLV_VIDEO; break;
	case "iPhone": $filename = $videoData->link_iPhone_VIDEO; break;
	case "Other": $filename = $videoData->link_other_VIDEO; break;
		
	}
	
	
	//Set file path

    $file_path = fileDownloadURL($filename,$client->folder_CLIENT);

	//Create DB link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
	
	
	$filmID = $dbLink->real_escape_string($_GET['ref']);
	
		
	//Can't connect to DB
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to download database (function: download).');
		
	//Update Download Log Entires		
		$dbLogQuery = sprintf(
			'INSERT INTO download_log (_kf_video_DOWNLOAD,filename_DOWNLOAD,filetype_DOWNLOAD,timestamp_DOWNLOAD) VALUES (%d,"%s","%s",NOW())',$filmID,$filename,$_GET['format']);
	
		$dbLogResult = $dbLink->query($dbLogQuery);
		
		//General Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when updating download log data');

		
      }
      	catch(Exception $thisException)
		{
		include('error.php'); 
		
		die;
		
		} 
	
	//Download redirect path
	
	 header("Location: $file_path");
	


?>
