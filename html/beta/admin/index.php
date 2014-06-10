<?php

ini_set('date.timezone','Europe/London');
session_start();

if (isset($_SESSION['username'])) {

header("Location: home.php");
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Admin Login</title>

<script type="text/javascript" language="JavaScript1.2"><!--

var formVerify = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Username
	if (document.adminLogin['username'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Username not entered';
	//Password
	if (document.adminLogin['password'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Password not entered';
	
	if (errorMsgOrder.length != 0)
		errorMsg = 'Error: ' + errorMsgOrder.join(', ') + '.';
	if (errorMsg.length > 0) {
		alert(errorMsg);
		return false;
	}
	
	document.getElementById("status").style.visibility="visible";
	document.newProfile.submitButtonName.disabled = true;
	return true;
	
};


//-->
</script>

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Administrator Login</h2>

<form id="adminLogin" action="login.php" method="post" name="adminLogin" enctype="multipart/form-data" onsubmit="return formVerify();">
  <table width="96%" class="content" align="center" style="border:none">
      <tr>
        <td width="43%" align="right" style="border:none">Username:</td>
    <td width="57%" align="left" style="border:none"><input name="username" type="text" size="32" class="cp_form_button" autofocus="autofocus" /> </td></tr>
    <td width="43%" align="right" style="border:none">Password:</td>
    <td width="57%" align="left" style="border:none"><input name="password" type="password" size="32" class="cp_form_button"/></td></tr>
    <tr><td colspan="2" align="center" style="border:none">&nbsp;</td></tr>
    <tr><td colspan="2" align="center" style="border:none">
    <input name="submitButtonName" type="submit" value="Login to Admin Area" onSubmit="return formVerify()" class="cp_form_button"/></td></tr>
   </table>
</form>

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 
    <?php echo date('Y');
?>
    </p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
