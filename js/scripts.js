// DOM Ready
$(function() {

// PNG Fallback for SVG
if(!Modernizr.svg) {
    $('img[src*="svg"]').attr('src', function() {
        return $(this).attr('src').replace('.svg', '.png');
    });
}


// Basic FitVids
        $(".container").fitVids();
        $(".videoWrapper").fitVids();
        
// Placeholder
        $('input, textarea').placeholder();
       
$('.btn-group > .btn').click(function (e) {
 $('.btn-group > .btn').removeClass('tb-active')
  $(this).addClass('tb-active')
});
        
$('#large-thumb').click(function (e) { 
	e.preventDefault();
	$(".thumbnail-options").removeAttr('class');
	$(".video-wrap").parent().addClass("col-xs-12 col-sm-12 col-md-12 thumbnail-options");
});

$('#medium-thumb').click(function (e) { 
	e.preventDefault();
	$(".thumbnail-options").removeAttr('class');
	$(".video-wrap").parent().addClass("col-xs-12 col-sm-6 col-md-6 thumbnail-options");
});

$('#small-thumb').click(function (e) { 
	e.preventDefault();
	$(".thumbnail-options").removeAttr('class');
	$(".video-wrap").parent().addClass("col-xs-12 col-sm-6 col-md-4 thumbnail-options");
});

$('.dropdown-menu li a').click(function (e) { 
	$(".downloaded").fadeIn("slow").delay(2000).fadeOut("slow");
});

$('#show-download-btn').click(function (e) { 
	e.preventDefault();
	$("#dl-info").fadeIn("fast");
	$("#show-download").fadeIn("slow");
});

// Phone menu visible
$("#phone_visible").click(function(e){
e.preventDefault();
$(".phone-menu").fadeToggle("fast");
     
});


});

