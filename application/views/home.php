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
        <li id="moreBtn" data-jq-dropdown="#jq-dropdown-more">More</li>
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