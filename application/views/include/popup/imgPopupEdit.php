<div id="imgBox" class="shadowWrapper isImgBoxEdit">
	<script src="<?php echo base_url('/resource/js/lib/typeahead.bundle.min.js')?>"></script>
	<script src="<?php echo base_url('/resource/js/autogrow.min.js')?>"></script>
	<script src="<?php echo base_url('/resource/js/popupBoxEdit.js')?>"></script>
	<span id="authorBox"><?php echo $imgObj->getAuthor()->getUsername().' '.date('Y-m-d', strtotime($imgObj->getCreated()));?></span>
	<div class="shadowLayer baseLayer"></div>
	<div class="baseLayer">
		<div class="mainBox">
		<form action="/publish" method="post">
			<div class="popupImg" id="imgTitle"><input type="text" id="imgTitle" name="imgTitle" value="<?php echo $imgObj->getTitle();?>"></div>
			<div class="popupImg loadingBg" id="popImgBox"></div>
			<div class="popupImg" id="popImgText">
				<span class="innerBox">
					<div id="imgAuthorTags" class="itag"><a id="authorTag" href="#">North Fan</a></div>
							<span id="imgTags"><?php
								$tags = $imgObj->getTags();
								foreach ($tags as $item) {
									echo "<div class='itag'><a href='".base_url('/tags/'.$item->getId())."'>".$item->getTagName()."</a></div>";
								}
								?></span>
				</span>
				<br>
				<span class="innerBox" id="imgTagNameAutoComplete">
					<input class="imgTagName typeahead" type="text" maxlength="20" placeholder="Tagging this photo"/>
				</span>
				<!--                &nbsp;&nbsp;&nbsp;-->
				<!--                <span>[Tagging this photo]</span>-->

				<div class="innerBox" id="imgText">
					<textarea name="imgDescription" id="imgDescription" placeholder="请在此输入内容..."><?php echo $imgObj->getText();?></textarea>
				</div>
				<div class="innerBox">
					<button class="btn-submit" type="button">Submit</button>
					<button class="btn-reset btn-smallpop-cancel" type="reset">Cancel</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>