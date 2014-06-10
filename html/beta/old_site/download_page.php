<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Circuit Pro - Downloading</title>


<link href="clientstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="images/cp_logo.jpg" alt="Insert Logo Here" name="Insert_logo id="Insert_logo" style="background: #C6D580; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="content">
  
    <h2>Downloading...</h2>



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
