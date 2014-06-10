<script>
$('.button').click( function(){
    window.open($('iframe').attr('src'),'mywindow','width=280,height=100');
});

var searchVerify = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Search 
	if (document.searchForm['searchstring'].value.length < 2 )
		errorMsgOrder[errorMsgOrder.length] = 'No valid search term';
		
	if (errorMsgOrder.length != 0)
		errorMsg = 'Search Error: ' + errorMsgOrder.join(', ') + '.';
	if (errorMsg.length > 0) {
		alert(errorMsg);
		return false;
	}
	
	return true;
	
	};

</script>

<div class="sidebar"><! Sidebar Section >
<div id="header-side"><a href="<?php echo $client->username_CLIENT; ?>/home"><i class="icon-home"></i> Welcome, <? echo $client->name_CLIENT; ?></a></div>
<ul class="navigation">
<li class="title-news"><i class="icon-align-justify"></i> Menu</li>
<li class="title-news"><form action="<? echo $client->username_CLIENT; ?>/search" method="post" name="searchForm" enctype="multipart/form-data" onsubmit="return searchVerify();">
<input class="text-field" name="searchstring" type="text"  placeholder="Search content" />
</form></li>

<li><a href="http://www.circuitpro.co.uk/client/">Home</a></li>

<? if (fetchProjectCount($client->_kp_CLIENT,"Active")) { ?>
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Active Projects</a></li>
<? } ?>


<? if (fetchProjectCount($client->_kp_CLIENT,"Completed")) { ?>
<li><a href="<?php echo $client->username_CLIENT; ?>/projects">Completed Projects</a></li>
<? } ?>


<li><a href="<?php echo $client->username_CLIENT; ?>/help">Help</a></li>

<li><a href="<?php echo $client->username_CLIENT; ?>/logout">Logout</a></li>

<li><a href="#">&nbsp;</a></li>




</ul>
</div>

<! END Sidebar Section >