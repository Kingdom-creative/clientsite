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
    <!-- end .footer -->
  </div>