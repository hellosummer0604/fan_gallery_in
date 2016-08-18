<div class="headerNavBackground">

</div>
<nav class="headerNav">
    <span class="float_left bigLogo">North Gallery</span>
	<?php
		$temp = ONLINE_FLAG;
		$isOnline = $$temp;
		if ($isOnline) {
	?>
			<span class="userBanner">
				<span class="font_size_16 navBtn accountBtn" data-jq-dropdown="#jq-dropdown-account">Hello, Summery</span>

				<div id="jq-dropdown-account"
					 class="jq-dropdown jq-dropdown-tip jq-dropdown-anchor-right jq-dropdown-relative">
					<ul class="jq-dropdown-menu">
						<li><a href="#1">My Account</a></li>
						<li><a href="#" data-popup-view="/upload" data-popup-style="popup_upload">Quick Upload</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="<?php echo base_url()?>">Homepage</a></li>
						<li><a href="<?php echo base_url("/u/infocenter")?>">Photographs</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#8">Settings</a></li>
						<li><a id="logoutBtn" href="#10">Logout</a></li>
					</ul>
				</div>

			</span>
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

