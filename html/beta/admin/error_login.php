<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Client Pages - Login Error!</title>

<link href="../clientstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="../images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Admin Page - Protected Content</h2>
    
<p>Error Details:</p>
  <p><strong>Not Logged In / Admin Permissions Denied - Please <a href="index.php">return to the login page to sign in</a></strong></p>
  <p>If you are continually having this error, please contact <a href="mailto:ben.treston@circuitpro.co.uk?Subject=Admin%20Area%20Error" ><u>System Administrator</u></a> with details of the error noted and what you were doing at the time.</p>
  <p>
           
<br /><br />

    <!-- end .content --></div>
  <div class="footer">
    <p>&copy; Circuit Pro 
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
    </p>
    <!-- end .footer --></div>
<!-- end .container --></div>

</body>
</html>
