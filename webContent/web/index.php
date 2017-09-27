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

<!-- SERVICES -->
<script type="text/javascript" src="js/jquery.quicksand.js"></script>
<script type="text/javascript" src="js/services.js"></script>
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
<div class="inner_copyright">Collect from <a href="http://www.cssmoban.com/" target="_blank" title="网页模板">网页模板</a></div>
<!-- BEGIN TIMELINE -->
<div class="timelineLight tl">
		<div class="item" data-id="7/5/2017" data-description="突发奇想">
			<a class="image_rollover_bottom con_borderImage" data-description="ZOOM IN" href="images/thumbnails/1a.jpg" rel="lightbox[timeline]">
			<img src="images/thumbnails/1.jpg" alt="" />
			</a>
			<h2>2017/05/07</h2>
			<span>突发奇想<br>我是一个程序员，整天做着白日梦，今天我突然产生一个奇怪的想法！我想去做一些平时没做过的事！所以我决定开发一个网站，让大家看到我做事的过程！也许你会...</span>
			<div class="read_more" data-id="7/5/2017">Read More</div>
		</div>
		 <div class="item_open" data-id="7/5/2017">
			<img class="con_borderImage" src="images/timeline_content/1w.jpg" />
			<div class="timeline_open_content">
			<h2 class="no-marg-top">想法的开始</h2>
			我是一个程序员，整天做着白日梦，今天我突然产生一个奇怪的想法！我想去做一些平时没做过的事！所以我决定开发一个网站，让大家看到我做事的过程！也许你会加入我！
			</div>
		</div>

		<div class="item" data-id="14/5/2017" data-description="开始行动">
			<a class="image_rollover_bottom con_borderImage" data-description="ZOOM IN" href="images/thumbnails/2a.jpg" rel="lightbox[timeline]">
			<img src="images/thumbnails/2.jpg" alt="" />
			</a>
			<h2>2017/05/14</h2>
			<span>开始行动<br>经过一个星期的思考，今天我开始行动了，我开始了网站的开发，不过我还是没想太好网站具体的样子，为了减少工作量，我在网上搞了点模板，希望这是一个美好的开始！</span>
			<div class="read_more" data-id="14/5/2017">Read More</div>
		</div>
		 <div class="item_open" data-id="14/5/2017">
			<img class="con_borderImage" src="images/timeline_content/2w.jpg" />
			<div class="timeline_open_content">
			<h2 class="no-marg-top">开始行动</h2>
			经过一个星期的思考，今天我开始行动了，我开始了网站的开发，不过我还是没想太好网站具体的样子，为了减少工作量，我在网上搞了点模板，希望这是一个美好的开始！
			</div>
		</div>
</div> 
<!-- /END TIMELINE -->

<!-- BEGIN middle_silver_background with icons  -->
<!-- <div class="middle_silver_background">
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
</div> -->
		
<!-- /END middle_silver_background with icons -->

<!-- BEGIN middle part -->
<section id="content">


<!-- first part -->
<h3 class="marg-top40">有意思的想法</h3>
<div class="con_border"></div>
<div class="column column-1-3  marg-top">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/top1.jpg" alt="" />
	</a>
	<div class="blog_content_info con_borderGray">
		<div class="blog_content_date">5<br /><span>/14</span></div>
		<a href="blog_post.php" class="comment_number">0</a>
		<div class="clear"></div>
	</div>
	<div class="blog_content_excerpt">
		<div class="padd-bott5 bold colorBlack">向陌生人借钱</div>
		人人都害怕被拒绝，为了让我克服这种心理，我打算在QQ上向陌生人借钱，我将用我能想到的各种办法去借钱，同时我会把聊天截图发到这个网站上和大家分享
	</div>
</div>

<!-- <div class="column column-1-3  marg-top">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/top2.jpg" alt="" />
	</a>
	<div class="blog_content_info con_borderGray">
		<div class="blog_content_date">9<br /><span>MARCH</span></div>
		<a href="blog_post.php" class="comment_number">15</a>
		<div class="clear"></div>
	</div>
	
	<div class="blog_content_excerpt">
		<div class="padd-bott5 bold colorBlack">Tincidunt rutrum</div>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet. Lorem ipsum dolor sit amet, consectetur adipiscing.
	</div>
</div>
<div class="column column-1-3 column-last  marg-top">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/top3.jpg" alt="" />
	</a>
	<div class="blog_content_info con_borderGray">
		<div class="blog_content_date">9<br /><span>MARCH</span></div>
		<a href="blog_post.php" class="comment_number">15</a>
		<div class="clear"></div>
	</div>
	
	<div class="blog_content_excerpt">
		<div class="padd-bott5 bold colorBlack">Sapient porta sit</div>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at semper risus. Curabitur mattis dapibus quam, tincidunt rutrum sapient porta sit amet. Lorem ipsum dolor sit amet, consectetur adipiscing.
	</div>
</div> -->
<div class="clear"></div>
<!-- /frst part -->


<!-- second part -->
<h3>我们需要的人才</h3>
<div class="con_border"></div>
<div class="column column-1-4  marg-top text-center">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/1.jpg" alt="" />
	</a>
	<b class="colorBlack">网页设计师</b><br />
	加入我，让我们的网站更加炫酷
</div>

<div class="column column-1-4  marg-top text-center">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/2.jpg" alt="" />
	</a>
	<b class="colorBlack">网站开发工程师</b><br />
	加入我，让我们的网站更加友好
</div>

<div class="column column-1-4  marg-top text-center">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/3.jpg" alt="" />
	</a>
	<b class="colorBlack">文案编辑人员</b><br />
	加入我，让我们的网站更加丰满
</div>

<div class="column column-1-4 column-last  marg-top text-center">
	<a class="image_rollover_bottom marg-bott" data-description="READ MORE" href="services_page.php">
		<img src="images/home/4.jpg" alt="" />
	</a>
	<b class="colorBlack">像我一样的搞怪分子</b><br />
	加入我，让我们的网站更加有趣
</div>
<div class="clear"></div>

<!-- /second part -->





<div class="clear"></div>
</section>
<!-- /END middle part -->

<!-- BEGIN footer -->
<?php include $_SERVER['DOCUMENT_ROOT']."/doit/webContent/web/footer.php"; ?>

<!-- /END footer -->

</body>
</html>
