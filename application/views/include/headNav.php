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
				<span class="font_size_14 navBtn logoutBtn" data-jq-dropdown="#jq-dropdown-logout">Log out</span>
				<span class="font_size_14 navBtn accountBtn" data-jq-dropdown="#jq-dropdown-account">My account</span>

				<div id="jq-dropdown-account"
					 class="jq-dropdown jq-dropdown-tip jq-dropdown-scroll jq-dropdown-relative">
					<ul class="jq-dropdown-menu">
						<li><a href="#1">Item 1</a></li>
						<li><a href="#2">Item 2</a></li>
						<li><a href="#3">Item 3</a></li>
						<li><a href="#4">Item 4</a></li>
						<li><a href="#5">Item 5</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#6">Item 6</a></li>
						<li><a href="#7">Item 7</a></li>
						<li><a href="#8">Item 8</a></li>
						<li><a href="#9">Item 9</a></li>
						<li><a href="#10">Item 10</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#11">Item 11</a></li>
						<li><a href="#12">Item 12</a></li>
						<li><a href="#13">Item 13</a></li>
						<li><a href="#14">Item 14</a></li>
						<li><a href="#15">Item 15</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#16">Item 16</a></li>
						<li><a href="#17">Item 17</a></li>
						<li><a href="#18">Item 18</a></li>
						<li><a href="#19">Item 19</a></li>
						<li><a href="#20">Item 20</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#21">Item 21</a></li>
						<li><a href="#22">Item 22</a></li>
						<li><a href="#23">Item 23</a></li>
						<li><a href="#24">Item 24</a></li>
						<li><a href="#25">Item 25</a></li>
						<li class="jq-dropdown-divider"></li>
						<li><a href="#26">Item 26</a></li>
						<li><a href="#27">Item 27</a></li>
						<li><a href="#28">Item 28</a></li>
						<li><a href="#29">Item 29</a></li>
						<li><a href="#30">Item 30</a></li>
					</ul>
				</div>
				<div id="jq-dropdown-logout" class="jq-dropdown jq-dropdown-tip has-icons jq-dropdown-relative">
					<div class="jq-dropdown-panel-narrow">
						<ul>
							<li><a href="#">Confirm</a></li>
							<li><a href="#26">Cancel</a></li>
						</ul>
					</div>
				</div>
			</span>
	<?php
		} else {
	?>
			<span class="userBanner">
    		<span class="font_size_14 navBtn signupBtn" id="upload">Sign up</span>
    		<span class="font_size_14 navBtn loginBtn">Sign in</span>
	</span>
	<?php
		}
	?>
</nav>

