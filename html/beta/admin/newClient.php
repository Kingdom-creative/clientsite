<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['admin_username'])) {

	
} else {

header("Location: error_login.php");
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Admin Area / Add Client</title>

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

var formVerifyClient = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Name
	if (document.formClient['clientName'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Client Name not entered';
	//Username
	if (document.formClient['clientUsername'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Client Username not entered';
	//Password
	if (document.formClient['clientPassword'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Client Password not entered';
	//Folder
	if (document.formClient['clientFolder'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Client Folder not entered';
	
	
	if (errorMsgOrder.length != 0)
		errorMsg = 'Error: \n' + errorMsgOrder.join('\n') + '.';
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
<form action="addClient.php" method="post" style="display: inline" id="formClient" name="formClient" enctype="multipart/form-data" onsubmit="return formVerifyClient();">
      <tr>
        <td width="39%"><strong>Add New Client</strong></td>
    <td width="61%" align="left"><strong>
   
     </strong>
    </td></tr>
      
            <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Client Name:</td>
        <td align="left"><label>
          <strong><input name="clientName" type="text" class="cp_form_input" size="50" /></strong>
        </label></td>
      </tr>
	  
	  <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Username:</td>
        <td align="left"><label>
          <strong><input name="clientUsername" type="text" class="cp_form_input" size="50" /></strong>
        </label></td>
      </tr>
	  
	    <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Password:</td>
        <td align="left"><label>
          <strong><input name="clientPassword" type="text" class="cp_form_input" size="50" /></strong>
        </label></td>
      </tr>
	  
	    <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
        <td align="right">Folder:</td>
        <td align="left"><label>
          <strong><input name="clientFolder" type="text" class="cp_form_input" size="50" /></strong>
        </label></td>
      </tr>
 
      
             
    

      <tr style="color:#8B8B8B;
	background-color: #FFF;border: 0px;">
  <td>&nbsp;</td>
  <td align="left"><input name="addProjectSubmit" type="submit" value="Add Client" class="cp_form_button"/><input type="reset" value="Clear" class="cp_form_button"/></td>
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
