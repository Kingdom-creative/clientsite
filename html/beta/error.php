 <? include ('head.php'); ?>



<div class="modal">
    <div class="modal-header">
    <img src="http://www.circuitpro.co.uk/images/circuit-pro-logo.png">
    </div>
    <div class="modal-body"><h4>Error:</h4>
    <p><?php print($thisException->getMessage()); ?></p>
   
   
    

    </div>
    <div class="modal-footer">

    <input class="btn btn-warning" name="submitButtonName" type="submit" value="Back" onclick="history.back()" />
    </div>



</body>
</html>
