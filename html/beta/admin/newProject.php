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
		
      $dbClientQuery = sprintf(
			'SELECT _kp_CLIENT, name_CLIENT FROM client ORDER BY name_CLIENT');
				
		$dbResultClient = $dbLink->query($dbClientQuery);
		
		//Query error
		if( $dbLink->errno )
			throw new Exception('An error occurred when querying the database for client data');
		
		
      }
      	catch(Exception $thisException)
	{
		include('error.php');
		die;
	}
	
} else {

header("Location: error_login.php");
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Admin Area / add</title>

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
	
	//Username
	if (document.formProject['projTitle'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Project title blank';
		
	//Client Selected
	if (document.formProject['clientID'].value == "0")
		errorMsgOrder[errorMsgOrder.length] = 'Client not selected';
			
	//Client Checklists
	if (document.formProject['check1'].value.length == 0 || document.formProject['check2'].value.length == 0 || document.formProject['check3'].value.length == 0 || document.formProject['check4'].value.length == 0 || document.formProject['check5'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Client checklist not completed';
		
	//Deadline dates
	if (document.formProject['date_firstDelivery'].value.length == 0 && document.formProject['date_approval'].value.length == 0 && document.formProject['date_finalDelivery'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Dates not completed';
		
	//Staff
	if (document.formProject['prodMgr'].value == "0")
		errorMsgOrder[errorMsgOrder.length] = 'Production Manager not selected';
		
	
	
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
   
    
<table width="96%" class="content" align="center" style="border:none">
<form action="addProject.php" method="post" style="display: inline" id="formProject" name="formProject" enctype="multipart/form-data" onsubmit="return formVerifyProject();">
      <tr>
        <td width="39%"><strong>Add New Project</strong></td>
    <td width="61%" align="left"><strong>
   
     </strong>
    </td></tr>
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Client:</td>
        <td align="left"> <select name="clientID" class="cp_form_input">
        <option value="0">Select client...</option>
    <?php  while( $clientDetail = $dbResultClient->fetch_object()) {
     
	 printf('<option value="%d">%s</option>',$clientDetail->_kp_CLIENT,$clientDetail->name_CLIENT);
	 
	} ?>
    </select>
        </td>
      </tr>
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Project Title:</td>
        <td align="left">
          <strong><input name="projTitle" type="text" class="cp_form_input" size="70" /></strong>
       </td>
      </tr>
 
      
              <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Added Date:</td>
        <td align="left"><input name="added" value="<?php echo date('Y\-m\-d'); ?>" class="cp_form_input"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('added', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What do you want to achieve with the project?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check1" id="check1"></textarea></strong>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What duration are the film(s) going to be?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check4" id="check4"></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">How/where will the film(s) be viewed?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check2" id="check2"></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What video format do you need the film(s) to be in?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check3" id="check3"></textarea></strong>
        </td>
      </tr>
      
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">What graphics appear during the film(s)?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="check5" id="check5"></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">First Edit Delivered:</td>
        <td align="left"><input name="date_firstDelivery" class="cp_form_input"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_firstDelivery', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Client Feedback/Approval:</td>
        <td align="left"><input name="date_approval" class="cp_form_input"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_approval', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Final Edit Delivered:</td>
        <td align="left"><input name="date_finalDelivery" class="cp_form_input"> 
<input type=button class="cp_form_button" onclick="displayDatePicker('date_finalDelivery', false, 'ymd', '-');" value="Choose Date"></td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Production Manager:</td>
        <td align="left"> <select name="prodMgr" class="cp_form_input" style="width:200px">
        <?php $prodManagerData = fetchStaffviaType("Production Manager"); ?>
        <option value="0">Select...</option>
    <?php  while( $staffDetail = $prodManagerData->fetch_object()) {
     
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF);
	 
	} ?>
    </select>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Creative Manager:</td>
        <td align="left"> <select name="creativeMgr" class="cp_form_input" style="width:200px">
        <?php $creativeMgrData = fetchStaffviaType("Creative Manager"); ?>
        <option value="0">Select...</option>
    <?php  while( $staffDetail = $creativeMgrData->fetch_object()) {
     
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF);
	 
	} ?>
    </select>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Editor:</td>
        <td align="left"> <select name="editor" class="cp_form_input" style="width:200px">
        <?php $editorData = fetchStaffviaType("Editor"); ?>
        <option value="0">Select...</option>
    <?php  while( $staffDetail = $editorData->fetch_object()) {
     
	 printf('<option value="%d">%s</option>',$staffDetail->_kp_STAFF,$staffDetail->name_STAFF);
	 
	} ?>
    </select>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Any additional points to note?:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="notes_ext" id="notes_ext"></textarea></strong>
        </td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Internal notes:</td>
        <td align="left">
          <strong><textarea rows="4" cols="50" class="cp_form_input" name="notes_int" id="notes_int"></textarea></strong>
        </td>
      </tr>
      
      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Live on client site:</td>
        <td align="left"><input name="live" type="checkbox" class="cp_form_input" value="live" checked="yes"/></td>
      </tr>

      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="left"><input name="addProjectSubmit" type="submit" value="Add Project" class="cp_form_button"/><input type="reset" value="Clear" class="cp_form_button"/></td>
</tr>
</form>
</table>

<p>&nbsp;</p>


<p>&nbsp;</p>


<table width="96%" class="content" align="center" style="border:none">
<tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="right"><form action="logout.php" method="post" style="display: inline"><input name="download" type="submit" value="Logout" class="cp_form_button"/></form></td>
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
