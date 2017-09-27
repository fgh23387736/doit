<?php 
	$url_page=explode('/', $_SERVER['PHP_SELF']);
	$url_page=explode('.', $url_page[count($url_page)-1]);
	$url_page=$url_page[0];
?>
<header class="header_silverbackground">
	<div class="menu">
		<!-- BEGIN logo -->
		<a class="logo" href="index.php"><img src="images/logo.png" alt="logo" style="height:40px;margin-top:20px;" /></a>
		<!-- /END logo -->
	<div class="blockeasing-wrapp">
	<h6 class="blockeasing-header">Menu</h6>
	<ul class="blockeasing">
        <li class="<?php 
        	if($url_page=='index'||
        		$url_page=='index_layout_v1'||
        		$url_page=='index1') 
        		echo 'current';?>"><a href="index.php">首页</a>
		<!-- <ul>
			<li><a href="index.php">SLIDE 1</a>
		            	<ul>
		              	<li><a href="index_layout_v1.php">HOME LAYOUT V1</a></li>
		            	</ul>
			</li>
			<li><a href="index1.php">SLIDE 2</a>
		            	<ul>
		            	<li><a href="index1_layout_v1.php">HOME LAYOUT V1</a></li>
		            	</ul>
			</li>
			 	</ul> -->
	 	</li>
		<li class="<?php if($url_page=='our-team') echo 'current';?>"><a href="our-team.php">我们的团队</a></li>
		<!-- <li class="<?php if($url_page=='blog'||$url_page=='blog_post') echo 'current';?>"><a href="blog.php">BLOG</a>
			<ul>
		        		<li><a href="blog_post.php">POST EXAMPLE</a></li>
			  		</ul>
		</li> -->
        <li class="<?php if($url_page=='services'||$url_page=='services_page') echo 'current';?>"><a href="services.php">大家的想法</a>
			<!-- <ul>
			      			<li><a href="services_page.php">SERVICES PAGE</a></li>
				  		</ul> -->
		</li>
        <!-- <li class="<?php if($url_page=='contact') echo 'current';?>"><a href="contact.php">联系我</a></li> -->
	</ul>
	</div>
	<div class="clear"></div>
    </div> 
</header>