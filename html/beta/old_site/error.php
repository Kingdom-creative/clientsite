<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Pages - Error!</title>


<link href="clientside.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="container">
  <div id="header">
    <div id="headernav">
      <a href="http://www.circuitpro.co.uk">Back to Circuit Pro Website</a>
    </div>
    <div id="headertag">Client Page - Error!</div>
  </div>
  <div class="content"> 
    
    <div class="content">
  <div class="message">
      
<h2>Error Details:</h2>
  <p><strong><?php print($thisException->getMessage()); ?></strong></p>
  <p>If you are continually having this error, please contact <a href="mailto:ben.treston@circuitpro.co.uk?Subject=Client%20Area%20Error" ><u>System Administrator</u></a> with details of the error noted and what you were doing at the time.</p>
  <p>
    <input type="button" value="Go Back" onclick="history.back()" />
</div>
    <!-- end .content --></div>
    
  <div id="footer"><span class="floatLeft">&nbsp;&nbsp;e:
    <script type='text/javascript'>//<![CDATA[
	  var a = new Array('.co.uk','circuitpro','info@');document.write("<a href='mailto:"+a[2]+a[1]+a[0]+"'>"+a[2]+a[1]+a[0]+"</a>");
	  //]]></script>
    &nbsp;&nbsp;</span><span class="floatRight">&copy;
    <?php 
echo date('Y');
?>
    Circuit Pro Limited</span> </div>
<!-- end .container --></div>

</body>
</html>
