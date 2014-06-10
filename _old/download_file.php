<?php

//Function to force download of video file

/*ob_start();

echo "<script language=javascript>alert('File Downloading')</script>";

ob_end_flush;*/

ob_start();

$path = $_POST['path'];
$file = $_POST['file'];

  // Must be fresh start 
  if( headers_sent() ) 
    die('Error: Headers Sent'); 

  // Required for some browsers 
  if(ini_get('zlib.output_compression')) 
    ini_set('zlib.output_compression', 'Off'); 

  // File Exists? 
  if( file_exists($path) ){ 
    
    // Parse Info / Get Extension 
    $fsize = filesize($path); 
    $path_parts = pathinfo($path); 
    $ext = strtolower($path_parts["extension"]); 
    
    // Determine Content Type 
    switch ($ext) {
	  case "mov": $ctype="video/quicktime"; break;
	  case "mov": $ctype="audio/x-ms-wmv"; break;
	  case "flv": $ctype="video/x-flv"; break;
      case "exe": $ctype="application/octet-stream"; break; 
      case "zip": $ctype="application/zip"; break; 
      case "doc": $ctype="application/msword"; break; 
      case "xls": $ctype="application/vnd.ms-excel"; break; 
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
      case "gif": $ctype="image/gif"; break; 
      case "png": $ctype="image/png"; break; 
      case "jpeg": 
      case "jpg": $ctype="image/jpg"; break; 
      default: $ctype="application/force-download"; 
    } 

    header("Pragma: public"); // required 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-Type: application/octet-stream"); 
    header("Content-Disposition: attachment; filename=\"".basename($path)."\";" ); 
    header("Content-Transfer-Encoding: binary"); 
    header("Content-Length: ".$fsize); 
    ob_clean(); 
    flush();
	ob_end_flush();
	set_time_limit(0); 
    readfile( $path );
	exit;

  } else 
    die('Error: File Not Found'); 

?>