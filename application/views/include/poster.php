<section id="indexPoster" class="poster" data-src="<?php echo $src;?>" data-width="<?php echo $width;?>" data-height="<?php echo $height;?>">

</section>

<?php
	if (!empty($firstHeadline) || !empty($secondHeadline)) {
?>
	<section class="textSection font_color_666">
		<?php
			if (!empty($firstHeadline)) {
				echo "<div class=\"large\"><br>$firstHeadline</div>";
			}
		?>

		<?php
			if (!empty($secondHeadline)) {
				echo "<br><br><div class=\"small\">$secondHeadline</div>";
			}
		?>
	</section>
<?php
	}
?>
