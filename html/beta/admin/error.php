<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Login - Error!</title>


<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Client Login - Error</h2>
    
<p>Error Details:</p>
  <p><strong><?php print($thisException->getMessage()); ?></strong></p>
  <p>If you are continually having this error, please contact <a href="mailto:ben.treston@circuitpro.co.uk?Subject=Admin%20Area%20Error" ><u>System Administrator</u></a> with details of the error noted and what you were doing at the time.</p>
  <p>
    <input type="button" value="Go Back" onclick="history.back()" />
           
<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 2011</p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
