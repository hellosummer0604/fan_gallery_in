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
    		<span class="font_size_14 signupBtn" id="upload">Log out</span>
    		<span class="font_size_14 loginBtn">My account</span>
	</span>
	<?php
		} else {
	?>
			<span class="userBanner">
    		<span class="font_size_14 signupBtn" id="upload">Sign up</span>
    		<span class="font_size_14 loginBtn">Sign in</span>
	</span>
	<?php
		}
	?>
</nav>