<?php
extract($data);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<?php
		echo $headerCss;
		echo $headerJs;
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	</head>
	<body>
		<div id="imgBox" class="shadowWrapper">
			<div class="shadowLayer baseLayer">

			</div>

			<div class="baseLayer">

				<div class="closeBanner"> 
					<div class="closeButton">x</div>
				</div>

				<div class="popupImg">

				</div>

				<div class="popupImg">

				</div>
			</div>
		</div>

		<div id="uploadBox" class="shadowWrapper">

			<div class="shadowLayer baseLayer">

			</div>


			<div class="baseLayer">

				<div class="closeBanner"> 
					<div class="closeButton">x</div>
				</div>

				<div class="popupImg">
					<h2>Upload Photo</h2>
				</div>

			</div>
		</div>



		<!--		<div id="generalPopup">
						
				</div>-->


		<div class="headerNavBackground">

		</div>
		<nav class="headerNav">
			<span class="float_left">North Gallery</span>
			<span class="float_right font_size_14">Log in</span>
			<span class="float_right font_size_14" id="upload">Sign up</span>
		</nav>