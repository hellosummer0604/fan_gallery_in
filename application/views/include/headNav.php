<div class="headerNavBackground">

</div>
<nav class="headerNav">
    <div class="float_left bigLogo"><a href="<?php echo base_url()?>">North Gallery</a></div>
	<?php
		$temp = ONLINE_FLAG;
		$isOnline = $$temp;
		if ($isOnline) {
	?>
			<div class="userBanner">
				<div class="font_size_16 navBtn accountBtn" data-jq-dropdown="#jq-dropdown-account">Hello, <?php print_r(mb_strimwidth($this->utils->onlineUserName(), 0, 12, "..."))?></div>

				<div id="jq-dropdown-account"
					 class="jq-dropdown jq-dropdown-tip jq-dropdown-anchor-right jq-dropdown-relative">
					<ul class="jq-dropdown-menu">
						<li><a data-popup-view="/commingSoon" data-popup-style="popup_settings">My Account</a></li>
						<li><a href="#" data-popup-view="/upload" data-popup-style="popup_upload">Quick Upload</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="<?php echo base_url("/user/".$this->utils->isonline())?>">Homepage</a></li>
						<li><a href="<?php echo base_url("/user/".REPO_URL)?>">Photographs</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#" data-popup-view="/settings" data-popup-style="popup_settings">Settings</a></li>
						<li><a id="logoutBtn" href="#10">Logout</a></li>
					</ul>
				</div>

			</div>
	<?php
		} else {
	?>
			<span class="userBanner">
    		<span class="font_size_16 navBtn signupBtn" id="upload">Sign up</span>
    		<span class="font_size_16 navBtn loginBtn">Sign in</span>
	</span>
	<?php
		}
	?>
</nav>

