		<?php 
			$url_page=explode('/', $_SERVER['PHP_SELF']);
			$url_page=explode('.', $url_page[count($url_page)-1]);
			$url_page=$url_page[0];
		 ?>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="index.php" class="<?php if($url_page=='index') echo 'active';?>"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
						<li><a href="elements.php" class="<?php if($url_page=='elements') echo 'active';?>"><i class="lnr lnr-code"></i> <span>Elements</span></a></li>
						<li><a href="charts.php" class="<?php if($url_page=='charts') echo 'active';?>"><i class="lnr lnr-chart-bars"></i> <span>Charts</span></a></li>
						<li><a href="panels.php" class="<?php if($url_page=='panels') echo 'active';?>"><i class="lnr lnr-cog"></i> <span>Panels</span></a></li>
						<li><a href="notifications.php" class="<?php if($url_page=='notifications') echo 'active';?>"><i class="lnr lnr-alarm"></i> <span>Notifications</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="<?php if($url_page=='page-profile') echo 'active'; else echo 'collapsed'?>"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse <?php if($url_page=='page-profile') echo 'in'; else echo ''?>">
								<ul class="nav">
									<li><a href="page-profile.php" class="<?php if($url_page=='page-profile') echo 'active'; else echo ''?>">Profile</a></li>
									<li><a href="page-login.php" class="">Login</a></li>
									<li><a href="page-lockscreen.php" class="">Lockscreen</a></li>
								</ul>
							</div>
						</li>
						<li><a href="tables.php" class="<?php if($url_page=='tables') echo 'active';?>"><i class="lnr lnr-dice"></i> <span>Tables</span></a></li>
						<li><a href="typography.php" class="<?php if($url_page=='typography') echo 'active';?>"><i class="lnr lnr-text-format"></i> <span>Typography</span></a></li>
						<li><a href="icons.php" class="<?php if($url_page=='icons') echo 'active';?>"><i class="lnr lnr-linearicons"></i> <span>Icons</span></a></li>
					</ul>
				</nav>
			</div>
		</div>