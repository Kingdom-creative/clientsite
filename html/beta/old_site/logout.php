<?php

session_start();
session_destroy();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Area - Logged Out</title>


<link href="/client/clientside.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="container">
  <div id="header">
    <div id="headernav">
      <a href="http://www.circuitpro.co.uk">Back to Circuit Pro Website</a>
    </div>
    <div id="headertag">Client Area - Logged Out</div>
  </div>
  <div class="content">
  <div class="message">
  <h2>Logged Out</h2>
    <p>You have now been logged out - Please <a href="../">return to the login page to sign in</a></p>
 
</div>

    <!-- end .content --></div>
  <div id="footer"><span class="floatLeft">&nbsp;&nbsp;e:
    <script type='text/javascript'>//<![CDATA[
	  var a = new Array('.co.uk','circuitpro','info@');document.write("<a href='mailto:"+a[2]+a[1]+a[0]+"'>"+a[2]+a[1]+a[0]+"</a>");
	  //]]></script>
    &nbsp;&nbsp;</span><span class="floatRight">&copy;
    <?php 
ini_set('date.timezone','Europe/London');
$startYear = 2011;
$thisYear = date('Y');
if ($startYear == $thisYear) {
echo $startYear;
}
else {
echo "{$startYear} - {$thisYear}";
}
?>
    Circuit Pro Limited</span> </div>
<!-- end .container --></div>

</body>
</html>
