<div id="header">
    <div id="headernav">
      <?php if ($clientDetail->youtubeStats_CLIENT)  { ?>
      <a href="stats/index.php">Live Stats</a>&nbsp;&nbsp;/&nbsp;&nbsp;
      <?php } ?>
      <form action="logout.php" method="post">
        <input name="download" type="submit" value="Logout" />
      </form>
    </div>
    <div id="headertag">Client Area / <?php echo $clientDetail->name_CLIENT; ?> / home</div>
  </div>