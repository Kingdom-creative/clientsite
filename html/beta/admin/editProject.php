<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['admin_username'])) {


//DB Details

	include ('../db.php');
	include ('../functions.php');
    
      try {
	//Create link
	$dbLink = new mysqli(DBHOST, DBUSER, DBPASS, DBASE);
		
	//Can't connect
	if( mysqli_connect_errno() )
		throw new Exception('Could not connect to database.');
		

		//See if there are sort filters and adjust query
			
	$dbProjectQuery = 'SELECT * FROM project WHERE _kp_PROJECT = "'.$_GET['project'].'"';
	

		$dbResultProject = $dbLink->query($dbProjectQuery);

		
			//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for project data');
			
				//Get the client record out into object	
		$projDetail = $dbResultProject->fetch_object();
		
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

<title>Circuit Pro - Client Admin Area / Edit Project</title>

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


var formVerifyProject = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Project Title
	if (document.formProject['projTitle'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Project title blank';
		
	
	
	if (errorMsgOrder.length != 0)
		errorMsg = 'Submit Error: \n' + ('- ') + errorMsgOrder.join('\n- ') + '.';
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
	
	<p>&nbsp;</p>
 
    
<table width="96%" class="content" align="center">
<form action="updateProject.php" method="post" style="display: inline" enctype="multipart/form-data" id="formProject" name="formProject" onsubmit="return formVerifyProject();">
      <tr>
        <td width="39%"><strong>Edit Project Details:</strong></td>
    <td width="61%" align="left"><strong>
     </strong>
    </td></tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Project Title</td>
        <td align="left"><label>
          <input name="projTitle" type="text" class="cp_form_input" value="<?php echo $projDetail->title_PROJECT; ?>" size="50" />
        </label></td>
      </tr>
	  
	    <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What do you want to achieve with the project?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check1" id="check1"><?php echo $projDetail->check1_achieve_PROJECT; ?></textarea></strong>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What duration are the film(s) going to be?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check4" id="check4"><?php echo $projDetail->check4_duration_PROJECT; ?></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">How/where will the film(s) be viewed?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check2" id="check2"><?php echo $projDetail->check2_platform_PROJECT; ?></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What video format do you need the film(s) to be in?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check3" id="check3"><?php echo $projDetail->check3_format_PROJECT; ?></textarea></strong>
        </td>
      </tr>
      
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What graphics appear during the film(s)?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check5" id="check5"><?php echo $projDetail->check5_graphics_PROJECT; ?></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">First Edit Delivered:</td>
        <td align="left"><input name="date_firstDelivery" class="cp_form_input" value="<?php echo $projDetail->date_firstDelivery_PROJECT; ?>"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_firstDelivery', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Client Feedback/Approval:</td>
        <td align="left"><input name="date_approval" class="cp_form_input" value="<?php if($projDetail->date_approval_PROJECT != "0000-00-00") { echo $projDetail->date_approval_PROJECT; } ?>"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_approval', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Final Edit Delivered:</td>
        <td align="left"><input name="date_finalDelivery" class="cp_form_input" value="<?php if($projDetail->date_finalDelivery_PROJECT != "0000-00-00") { echo $projDetail->date_finalDelivery_PROJECT; } ?>"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_finalDelivery', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Production Manager:</td>
        <td align="left"> <select name="prodMgr" class="cp_form_input" style="width:200px">
		<?php $prodManagerCurrent = fetchStaffviaID($projDetail->_kf_staff_prodManager_PROJECT); ?>
		<?php printf('<option value="%d">%s</option>',$prodManagerCurrent->_kp_STAFF,$prodManagerCurrent->name_STAFF); ?> 
        <?php $prodManagerData = fetchStaffviaType("Production Manager"); ?>
    <?php  while( $staffDetail = $prodManagerData->fetch_object()) {
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF); } ?>
    </select>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Creative Manager:</td>
        <td align="left"> <select name="creativeMgr" class="cp_form_input" style="width:200px">
		<?php $creativeManagerCurrent = fetchStaffviaID($projDetail->_kf_staff_creativeManager_PROJECT); ?>
		<?php printf('<option value="%d">%s</option>',$creativeManagerCurrent->_kp_STAFF,$creativeManagerCurrent->name_STAFF); ?> 
        <?php $creativeManagerData = fetchStaffviaType("Creative Manager"); ?>
    <?php  while( $staffDetail = $creativeManagerData->fetch_object()) {
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF); } ?>
    </select>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Editor:</td>
        <td align="left"> <select name="editor" class="cp_form_input" style="width:200px">
		<?php $editorCurrent = fetchStaffviaID($projDetail->_kf_staff_editor_PROJECT); ?>
		<?php printf('<option value="%d">%s</option>',$editorCurrent->_kp_STAFF,$editorCurrent->name_STAFF); ?> 
        <?php $editorData = fetchStaffviaType("Editor"); ?>
    <?php  while( $staffDetail = $editorData->fetch_object()) {
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF); } ?>
    </select>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Any additional points to note?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="notes_ext" id="notes_ext"><?php echo $projDetail->notes_ext_PROJECT; ?></textarea></strong>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Internal notes:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="notes_int" id="notes_int"><?php echo $projDetail->notes_int_PROJECT; ?></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Project is live:</td>
        <td align="left"><?php if (empty($projDetail->live_PROJECT)) { ?>
        <input name="live" type="checkbox" value="" /><?php } else { ?>
        <input name="live" type="checkbox" value="1" checked="yes" /><?php } ?></td>
      </tr>
      
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Enable YouTube Stats Reporting:</td>
        <td align="left"><?php if (empty($projDetail->youtubeStats_PROJECT)) { ?>
        <input name="youtubeStats" type="checkbox" value="" /><?php } else { ?>
        <input name="youtubeStats" type="checkbox" value="1" checked="yes" /><?php } ?></td>
      </tr>
	  
	   <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Project is completed:</td>
        <td align="left"><?php if ($projDetail->status_PROJECT != "Completed") { ?>
		<input name="completed" type="checkbox" value="" /><?php } else { ?>
		<input name="completed" type="checkbox" value="1" checked="yes"/><?php } ?>
		</td>
      </tr>
      
     

      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;<input name="projectID" type="hidden" value="<?php echo $projDetail->_kp_PROJECT; ?>" /></td>
  <td align="left"><input name="editProjectSubmit" type="submit" class="cp_form_button" value="Update Project" /></td>
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
