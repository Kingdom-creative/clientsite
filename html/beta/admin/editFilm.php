<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['admin_username'])) {


//DB Details

	include ('../db.php');
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		

		//See if there are sort filters and adjust query
			
	$dbFilmQuery = sprintf('SELECT * FROM video WHERE _kp_VIDEO ="%d"',$_GET['film']);
	

		$dbResultFilm = $dbLink->query($dbFilmQuery);

		
			//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for film data');
			
				//Get the client record out into object	
		$filmDetail = $dbResultFilm->fetch_object();
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
	}
	
} else {

header("Location: error_login.php");
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Admin Area / edit film</title>

<script type="text/javascript" src="../jquery.js"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script type="text/javascript">  
$(window).load(function(){  
      $("#loading").hide();  
})  
</script> 
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>

<script type="text/javascript" language="JavaScript1.2"><!--


var formVerifyFilm = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Username
	if (document.formFilm['filmTitle'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Film Title not entered';
	//Password
	if (document.formFilm['projectID'].value == "0")
		errorMsgOrder[errorMsgOrder.length] = 'Project Not Selected';
	
	if (errorMsgOrder.length != 0)
		errorMsg = 'Error: ' + errorMsgOrder.join(', ') + '.';
	if (errorMsg.length > 0) {
		alert(errorMsg);
		return false;
	}
	
	return true;
	
};


//-->
</script>

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
<link href="../datepicker.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />


</head>

<body>

<div id="loading">  
 <img src="../loader.gif" alt="loading.." />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading data, please wait.. 
</div>  

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
    <h2><a href="home.php" class="cp_form_button">Client Admin Home</a></h2>
 
 
    
<table width="96%" class="content" align="center">
<form action="updateFilm.php" method="post" style="display: inline" enctype="multipart/form-data" id="formFilm" name="formFilm" onsubmit="return formVerifyFilm();">
      <tr>
        <td width="39%"><strong>Edit Film Details:</strong></td>
    <td width="61%" align="left"><strong>
     </strong>
    </td></tr>
    
    <?php if ($filmDetail->vimeoID_VIDEO) { ?>
             <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="center" colspan="2">
        <?php	
	printf('<iframe src="http://player.vimeo.com/video/%d?title=0&amp;byline=0&amp;portrait=0&amp;color=c06715" width="520" height="293" frameborder="0"></iframe>',$filmDetail->vimeoID_VIDEO); ?>
        </td>
      </tr>
      <?php } ?>
    
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Film Title:</td>
        <td align="left"><label>
          <input name="filmTitle" type="text" class="cp_form_input" value="<?php echo $filmDetail->title_VIDEO; ?>" size="70" />
        </label></td>
      </tr>
            
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">Vimeo ID:</td>
              <td align="left"><input name="vimeoID" type="text" class="cp_form_input" value="<?php echo $filmDetail->vimeoID_VIDEO; ?>" size="15"/></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">Vimeo Password:</td>
              <td align="left"><input name="vimeoPassword" type="text" class="cp_form_input" value="<?php echo $filmDetail->password_VIDEO; ?>" size="15" /></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">YouTube ID:</td>
              <td align="left"><input name="youtubeID" type="text" class="cp_form_input" value="<?php echo $filmDetail->youtubeID_VIDEO; ?>" size="15"/>&nbsp;<?php if ($filmDetail->youtubeID_VIDEO) printf('<a href="http://www.youtube.com/watch?v=%s">View on YouTube</a>',$filmDetail->youtubeID_VIDEO); ?></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">QT File:</td>
              <td align="left"><input name="qt_file" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_QT_VIDEO; ?>" size="70" /></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">WMV File:</td>
              <td align="left"><input name="wmv_file" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_WMV_VIDEO; ?>" size="70"/></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">iPhone File:</td>
              <td align="left"><input name="iphone_file" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_iPhone_VIDEO; ?>" size="70"/></td>
            </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">FLV File:</td>
              <td align="left"><input name="flv_file" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_FLV_VIDEO; ?>" size="70" /></td>
            </tr>
			
			<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
              <td align="right">Other:</td>
              <td align="left"><input name="other_file" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_other_VIDEO; ?>" size="25" />&nbsp;Type:<input name="other_file_label" type="text" class="cp_form_input" value="<?php echo $filmDetail->link_otherLabel_VIDEO; ?>" size="25" /></td>
            </tr>

      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;<input name="filmID" type="hidden" value="<?php echo $filmDetail->_kp_VIDEO; ?>" /></td>
  <td align="left"><input name="addFilmSubmit" type="submit" class="cp_form_button" value="Update Film" /></td>
</tr>
</form>
</table>

<p>&nbsp;</p>


<table width="96%" class="content" align="center" style="border:none">
<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="logout.php" method="post" style="display: inline"><input name="download" type="submit" class="cp_form_button" value="Logout" /></form></td>
</tr>

</table>

<?php $dbLink->close(); ?>

<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro <?php echo date('Y'); ?></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>

</body>
</html>
