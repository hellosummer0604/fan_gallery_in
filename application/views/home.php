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
				<tr>
					<td colspan="3" class="disHover"><h3>All tags</h3></td>
				</tr>
				<tr>
					<td colspan="3" class="disHover"><hr></td>
				</tr>
				<tr>
					<td><a href="#">North Fan</a></td>
					<td><a href="#">Drink</a></td>
					<td><a href="#">Interior</a></td>
				</tr>
				<tr>
					<td><a href="#">Smoothy</a></td>
					<td><a href="#">Interior</a></td>
					<td><a href="#">Drink</a></td>
				</tr>
				<tr>
					<td><a href="#">Light</a></td>
					<td><a href="#">Drink</a></td>
					<td></td>
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



<?php
	foreach ($cateList as $item) {
//	$html = "<section class=\"bodySection imgSection\" id=\"" . $item . "\" style=\"display:none;\"><div class=\"beforeThis\"></div><div class=\"imgGroup pagingBanner\">++++++++++</div><div class=\"footer\" >" . $item . "</div></section>";
//	echo $html;
?>
	<section class="bodySection imgSection" id="<?php echo $item ?>" style="display:none;">
		<div class="beforeThis"></div>
		<div class="pagingBanner moreGroup">
			<a href="#" class="start">First</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a class="active" href="javascript: void(0)">4</a><a href="#">4</a><a href="#">4</a><a href="#">5</a><a href="#" class="end">Last</a>
		</div>

		<div class="footer" ><?php echo $item ?></div>
	</section>
<?php
	}
?>
</body>
</html>