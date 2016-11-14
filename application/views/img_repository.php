<!--img category nav start-->
<section class="imgNavContainer imgNavContainerBackground">

</section>

<section class="imgNavContainer imgNavContainerForeground">
    <span class="linkContainer">
		<?php
		foreach ($cateList as $key => $item) {
			echo "<li id='nav_$item' class='nav_li'>" . ucfirst($key) . "</li>";
		}
		?>
	<li id='nav_<?php echo TAG_FEATURED?>' class='nav_li'>Featured</li>
	<li><a data-popup-view="/commingSoon" data-popup-style="popup_settings">Categories</a></li>
	<li><a data-popup-view="/commingSoon" data-popup-style="popup_settings">Tags</a></li>
	<li><a data-popup-view="/settings" data-popup-style="popup_settings">Settings</a></li>
    </span>
</section>
<!--img category nav end-->

<!-- loading gif start -->
<!--<section class="bodySection loading">-->
<!--<div class="imgGroup">-->
<!--<img src="resource/img/loading.gif">-->
<!--</div>-->
<!--</section>-->
<!-- loading gif end -->
<section class="bodySection" style="background-color: #fcff93">

</section>

<!--<section class="bodySection">
	<div class="imgGroup" id="s12g2">
	</div>
	<div id="" class="imgGroup" style=" height: 212px; background-color: antiquewhite">

		
	</div>
	
</section>-->



<section class="bodySection imgSection" id="mainImgSection">
	<div class="beforeThis"></div>
	<div class="pagingBanner moreGroup">
	</div>

	<div class="footer" >footer</div>
</section>

</body>
</html>