


<!--img category nav start-->
<section class="imgNavContainer imgNavContainerBackground">

</section>

<section class="imgNavContainer imgNavContainerForeground">
    <span class="linkContainer">
		<li><a href="infocenter">Info</a></li>
		<?php
		foreach ($cateList as $key => $item) {
			echo "<li id='nav_$item' class='nav_li'>" . ucfirst($key) . "</li>";
		}
		?>
        <li>More</li>
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



<?php 
	foreach ($cateList as $item) {
		$html = "<section class=\"bodySection imgSection\" id=\"".$item."\" style=\"display:none;\"><div class=\"beforeThis\"></div><div class=\"moreGroup\">++++++++++</div><div class=\"footer\" >".$item."</div></section>";
		echo $html;
	}
?>
</body>
</html>