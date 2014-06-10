<?php
$page = 'login';

ini_set('date.timezone','Europe/London');
session_start();


if (isset($_SESSION['username'])) {

header("Location: ".$_SESSION['username']."/home");
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Circuit Pro - Client Login</title>
<script type="text/javascript" language="JavaScript1.2"><!--

var formVerify = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Username
	if (document.clientLogin['username'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Username not entered';
	//Password
	if (document.clientLogin['password'].value.length == 0)
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
<link href="clientside.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<div id="header">
    <div id="headernav">
      <a href="http://www.circuitpro.co.uk">Back to Circuit Pro Website</a>
    </div>
    <div id="headertag">Client Login</div>
  </div>
  
  <div class="content">
    <form id="clientLogin" action="login.php" method="post" name="clientLogin" enctype="multipart/form-data" onsubmit="return formVerify();">
      <table width="330" class="content" align="center" style="border:none">
        <tr>
          <td width="100px" align="left" style="border:none">Username:</td>
          <td width="250px" height="5" align="right" style="border:none"><input class="text-field" name="username" type="text" size="38" /></td>
        </tr>
        <td width="100px" align="left" style="border:none">Password:</td>
          <td width="250px" align="right" style="border:none"><input class="text-field" name="password" type="password" size="38" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="border:none">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="border:none"><input class="button" name="submitButtonName" type="submit" value="Login to Client Area" onSubmit="return formVerify()" /></td>
        </tr>
      </table>
    </form>
    <!-- end .content -->
  </div>
  <div id="footer"><span class="floatLeft">&nbsp;&nbsp;e:
    <script type='text/javascript'>//<![CDATA[
	  var a = new Array('.co.uk','circuitpro','info@');document.write("<a href='mailto:"+a[2]+a[1]+a[0]+"'>"+a[2]+a[1]+a[0]+"</a>");
	  //]]></script>
    &nbsp;&nbsp;</span><span class="floatRight">&copy;
    <?php 
echo date('Y');
?>
    Circuit Pro Limited</span> </div>
  <!-- end .container -->
</div>
</body>
</html>
