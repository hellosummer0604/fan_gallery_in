<!--img category nav start-->
<section class="imgNavContainer imgNavContainerBackground">

</section>

<section class="imgNavContainer imgNavContainerForeground">
    <span class="linkContainer">
		<?php
		foreach ($cateList as $key => $item) {
			if ($key == 'more') {
				echo "<li id='moreBtn' data-jq-dropdown='#jq-dropdown-more'>More</li>";
			} else {
				echo "<li id='nav_$item' class='nav_li'>" . ucfirst($key) . "</li>";
			}
		}
		?>

    </span>
	<div id="jq-dropdown-more" class="jq-dropdown jq-dropdown-scroll jq-dropdown-escape">
		<ul class="jq-dropdown-panel-narrow">
			<table cellspacing="0" cellpadding="0">
				<tr class="default">
					<td colspan="2" class="disHover"><h3>All tags</h3></td>
				</tr>
				<tr class="default">
					<td colspan="2" class="disHover"><hr></td>
				</tr>
				<tr class="default">
					<td colspan="2" class="disHover">Loading...</td>
				</tr>
			</table>
		</ul>
	</div>
</section>
<!--img category nav end-->

<!-- loading gif start -->
<!--<section class="bodySection loading">-->
<!--<div class="imgGroup">-->
<!--<img src="resource/img/loading.gif">-->
<!--</div>-->
<!--</section>-->
<!-- loading gif end -->
<section class="bodySection">

</section>

<section class="bodySection imgSection" id="mainImgSection">
	<div class="beforeThis"></div>
	<div class="pagingBanner moreGroup">
	</div>

	<div class="footer">
		<div class="mainSpan">
			<ul>
				<li>Site design/logo &copy; North.Gallery 2016</li>
				<li>Report Bug: hellosummer0604@gmail.com</li>
				<li>Photo Copyright: northyhades@gmail.com</li>
				<li>Rev 2016.11.13.191</li>
			</ul>
		</div>
	</div>
</section>

</body>
</html>