<div id="imgBox" class="shadowWrapper">
	<span id="authorBox"><?php echo $imgObj->getAuthor()->getUsername().' '.date('Y-m-d', strtotime($imgObj->getCreated()));?></span>
	<div class="shadowLayer baseLayer"></div>
	<div class="baseLayer">
		<div class="mainBox">

			<div class="popupImg" id="imgTitleBox"><?php echo $imgObj->getTitle();?></div>
			<div class="popupImg loadingBg" id="popImgBox"></div>
			<div class="popupImg" id="popImgText">
				<span class="innerBox">
					<div id="imgAuthorTags" class="itag"><a id="authorTag" href="<?php $userId = $imgObj->getAuthor()->getId(); echo base_url("user/$userId")?>"><?php echo $imgObj->getAuthor()->getUsername();?></a></div>
						<span id="imgTags"><?php
							$tags = $imgObj->getTags();
							foreach ($tags as $item) {
								echo "<div class='itag'><a href='".base_url("user/$userId/tag/".$item->getId())."'>".$item->getTagName()."</a></div>";
							}
						?></span>
				</span>
				<div class="innerBox" id="imgText"><?php echo $imgObj->getText();?></div>
			</div>

		</div>
	</div>
</div>

