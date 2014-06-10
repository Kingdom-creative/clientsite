<?php

ini_set('date.timezone','Europe/London');

try {

if(empty($_GET['folder'])) {throw new Exception('Client Folder not specified in page request'); }

$folder = $_GET['folder'];

$dir = '../video/'.$folder;

if (is_dir($dir) == false) { 

throw new Exception('Client Folder does not exist');}

}

      	catch(Exception $thisException)
	{
		include('error.php');
		die;
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Admin Area / File List - <?php echo $folder; ?></title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>

</head>

<body>


<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
   

<p>&nbsp;</p>

<table width="96%" class="content" align="center" style="border:none">

     
	 <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="left">FOLDER - <strong>/<?php echo $folder; ?></strong></td>
        </tr>
	 
	 

 <?php   
 
  
		chdir($dir); 
		array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_DESC, $files); 
		foreach($files as $filename) 
		{ 
    		$fullPath = 'http://87.194.168.172/client/video/'.$folder.'/'.rawurlencode($filename);
			
			printf('<tr style="color:#8B8B8B;background-color: #FFF;border: 0px;">
        <td align="left">
		%s<br />
		<input type="text" value="%s" size="150" onClick="SelectAll(\'%d\');" id="%d">
		</td>
        </tr>',$filename,$fullPath,$element,$element);
		
		$element++;  
		}  
 
 
/*  if ($dh = opendir($dir)) {
	 
	 	$element = 1;
	 	
        while (($file = readdir($dh)) !== false) {
			
		if ($file != "." && $file != "..") {
			
		$fullPath = 'http://87.194.168.172/client/video/'.$folder.'/'.rawurlencode($file);
			
			printf('<tr style="color:#8B8B8B;background-color: #FFF;border: 0px;">
        <td align="left">
		%s<br />
		<input type="text" value="%s" size="150" onClick="SelectAll(\'%d\');" id="%d">
		</td>
        </tr>',$file,$fullPath,$element,$element);
		
		$element++;
		
		 }
        
		}
        closedir($dh); }*/  ?>
      

</table>

<p>&nbsp;</p>




<p>&nbsp;</p>


    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>

</body>
</html>
