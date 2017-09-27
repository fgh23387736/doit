
<!-- # ------------------------------------------------------------------
# kickassGFX.net - Best Graphic Source - Free Themes, Scripts & Plugins 
# -----------------------------------------------------------------------
# This file has been downloaded from KickassGFX.net
# Homepage: http://www.kickassgfx.net/
# -----------------------------------------------------------------------
# You'll find your Updates everyday at KickassGFX.net
# -----------------------------------------------------------------------
# If you need support with this template you can
# contact us at   http://www.kickassgfx.net/
# ------------------------------------------------------------------- -->

<!DOCTYPE html> 
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Downloaded from KickassGFX.net</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/slider.css" rel="stylesheet" type="text/css" />
<link href="css/css_slider1/default.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/css_slider1/nivo-slider.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/hover.css" rel="stylesheet" type="text/css" />
<link href="css/columns.css" rel="stylesheet" type="text/css" />
<link href="css/hover_image.css" rel="stylesheet" type="text/css" />
<link href="css/lightbox.css" rel="stylesheet" type="text/css" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" />
<link href="css/widgets.css" rel="stylesheet" type="text/css" />
<link href="css/light.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/stimenu.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />



<!--[if IE 8]>
<link href="css/style_IE.css" rel="stylesheet" type="text/css">
<![endif]-->
<script type="text/javascript" src="js/ie.html5.js"></script>

<!-- JQUERY -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

<!-- JQUERY_UI -->
<script type="text/javascript" src="js/jquery.ui.core.js"></script>

<!-- SLIDER -->
<script type="text/javascript" src="js/jquery.cycle.js"></script>
<script type="text/javascript">
	$(window).load(function() {
		$("#scroller .items").cycle({ 
    		fx: 'scrollUp' 	
		});
	});
</script>

<!-- SLIDER_NIVO 
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('.nivo_slider').nivoSlider({
			manualAdvance: true,
			directionNavHide:true});
    });
</script>
-->

<!-- SLIDER_TIMELINE -->
<script type="text/javascript" src="js/jquery.timeline.min.js"></script>
<script type="text/javascript">

$(window).load(function() {
	// dark
	$('.timelineLight').timeline({
		openTriggerClass : '.read_more',
		startItem : '15/08/2012'
	});
});
</script>

<!-- SLIDER_PIECEMAKER
<script type="text/javascript" src="js/swfobject.js"></script>
 -->
 
<!-- MENU -->
<script type="text/javascript" src="js/menu.js"></script> 	
<script type="text/javascript" src="js/jquery.iconmenu.js"></script>

<!-- SERVICES 
<script type="text/javascript" src="js/jquery.quicksand.js"></script>
<script type="text/javascript" src="js/services.js"></script>
-->
<!-- HOVER_BUTTON -->
<script type="text/javascript" src="js/hover.js"></script>
<script type="text/javascript" src="js/buttons.js"></script>


<!-- IMAGE -->
<script src="js/image.js" type="text/javascript"> </script>
<script src="js/lightbox.js" type="text/javascript"></script>
<script src="js/jquery.capSlide.js" type="text/javascript"></script>

<!-- GALLERY 
<script src="js/lazyload.js" type="text/javascript"></script>
<script src="js/gallery.js" type="text/javascript"> </script>
<script src="js/jquery.masonary.js" type="text/javascript"> </script>
-->




<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>


<body>


<!-- BEGIN menu -->
<?php include $_SERVER['DOCUMENT_ROOT']."/doit/webContent/web/menu.php"; ?>
<!-- /END menu -->

<!-- BEGIN TIMELINE -->
<div class="timelineLight tl">
		<div class="item" data-id="04/06/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/1.jpg" alt="" />
			</a>
			<h2>JUNE, 4</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="04/06/2012">Read more</div>
		</div>
		<div class="item_open" data-id="04/06/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="12/06/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/2.jpg" alt="" />
			</a>
			<h2>JUNE, 12</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="12/06/2012">Read more</div>
		</div>
		<div class="item_open" data-id="12/06/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="21/06/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/3.jpg" alt="" />
			</a>
			<h2>JUNE, 21</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="21/06/2012">Read more</div>
		</div>
		<div class="item_open" data-id="21/06/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>


		<div class="item" data-id="27/06/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/4.jpg" alt="" />
			</a>
			<h2>JUNE, 27</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="27/06/2012">Read more</div>
		</div>
		<div class="item_open" data-id="27/06/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		
		<div class="item" data-id="03/07/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/5.jpg" alt="" />
			</a>
			<h2>JULY, 3</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="03/07/2012">Read more</div>
		</div>
		<div class="item_open" data-id="03/07/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		
		
		<div class="item" data-id="13/07/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/6.jpg" alt="" />
			</a>
			<h2>JULY, 13</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="13/07/2012">Read more</div>
		</div>
		<div class="item_open" data-id="13/07/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="17/07/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/7.jpg" alt="" />
			</a>
			<h2>JULY, 17</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="17/07/2012">Read more</div>
		</div>
		<div class="item_open" data-id="17/07/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="25/07/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/8.jpg" alt="" />
			</a>
			<h2>JULY, 25</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="25/07/2012">Read more</div>
		</div>
		<div class="item_open" data-id="25/07/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="06/08/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/9.jpg" alt="" />
			</a>
			<h2>AUGUST, 6</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="06/08/2012">Read more</div>
		</div>
		<div class="item_open" data-id="06/08/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="15/08/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/10.jpg" alt="" />
			</a>
			<h2>AUGUST, 15</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="15/08/2012">Read more</div>
		</div>
		<div class="item_open" data-id="15/08/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="20/08/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
			<img src="images/thumbnails/11.jpg" alt="" />
			</a>
			<h2>AUGUST, 20</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="20/08/2012">Read more</div>
		</div>
		<div class="item_open" data-id="20/08/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>
		
		<div class="item" data-id="26/08/2012" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit...">
			<a href="#" class="image_rollover_bottom">
				<img src="images/thumbnails/12.jpg" alt="" />
			</a>
			<h2>AUGUST, 26</h2>
			<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exerc...</span>
			<div class="read_more" data-id="26/08/2012">Read more</div>
		</div>
		<div class="item_open" data-id="26/08/2012">
			<div class="timeline_open_content">
			<h2>LOREM IPSUM DOLOR</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br /><br />
			
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
		</div>

</div> <!-- /END TIMELINE -->

<!-- BEGIN middle_silver_background with icons  -->
<div class="middle_silver_background">
		<div class="container">
			<ul id="sti-menu" class="sti-menu">
				<li data-hovercolor="#ffffff">
					<a href="#">
						<h2 data-type="mText" class="sti-item">Meet our team</h2>
						<h3 data-type="sText" class="sti-item">Connect designers</h3>
						<span data-type="icon" class="sti-icon sti-icon-one sti-item"></span>
					</a>
				</li>
				<li data-hovercolor="#ffffff">
					<a href="#">
						<h2 data-type="mText" class="sti-item">View our portfolio</h2>
						<h3 data-type="sText" class="sti-item">Professional work</h3>
						<span data-type="icon" class="sti-icon sti-icon-two sti-item"></span>
					</a>
				</li>
				<li data-hovercolor="#ffffff">
					<a href="#">
						<h2 data-type="mText" class="sti-item">Work with us</h2>
						<h3 data-type="sText" class="sti-item">You won't regret it</h3>
						<span data-type="icon" class="sti-icon sti-icon-three sti-item"></span>
					</a>
				</li>
				<li data-hovercolor="#ffffff">
					<a href="#">
						<h2 data-type="mText" class="sti-item">Publish your work</h2>
						<h3 data-type="sText" class="sti-item">Let it roar!</h3>
						<span data-type="icon" class="sti-icon sti-icon-four sti-item"></span>
					</a>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
</div>
		
<!-- /END middle_silver_background with icons -->

<!-- BEGIN middle part -->
<section id="content">

	<div class="href_path href_path_left">
		<img class="content_icon" src="images/icons/icon-1.png" alt="icon-1" />
		<a href="services.html"><h2>WEB DESIGN SERVICES</h2></a>
		<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet.</div>
	</div>

	<div class="href_path href_path_right">
		<img class="content_icon" src="images/icons/icon-2.png" alt="icon-2" />
		<a href="services.html"><h2>GRAPHIC DESIGN SERVICES</h2></a>
		<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Morbi non lacinia augue. Quam, tincidunt rutrum sapien porta sit amet.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet.</div>
	</div>

	<div class="href_path href_no_path_left">
		<img class="content_icon" src="images/icons/icon-3.png" alt="icon-3" />	
		<a href="services.html"><h2>SEO SERVICES</h2></a>
		<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus.  Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet.</div>
	</div>
	
<div class="clear"></div>
</section>
<!-- /END middle part -->



<!-- BEGIN footer -->
<?php include $_SERVER['DOCUMENT_ROOT']."/doit/webContent/web/footer.php"; ?>

<!-- /END footer -->

</body>
</html>
