<script src="<?php echo base_url('/resource/js/lib/dropzone.min.js')?>"/>
<!--<link rel='stylesheet' href='../resource/theme/default/css/basic.min.css'>-->
<link rel='stylesheet' href='<?php echo base_url('/resource/theme/default/css/dropzone.min.css')?>'>

<div class="colorBanner">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>

<div class="titleBox">
	<h2>UPLOAD YOUR PHOTOS</h2>
</div>

<div id="uploadDropbox">
	<form  class="dropzone" id="myDropzone">
		<div class="dz-message" data-dz-message>
			<img src="<?php echo base_url('/resource/theme/default/img/upload_imgs21.png')?>" />
			<div>Choose files or Drag them here</div>
		</div>
	</form>
</div>

<div id="btnSection">
	<button class="btn-submit" type="button">Upload</button>
	<button id="closeUpload" class="btn-reset" type="button">Cancel</button>
</div>

<script>
	jQuery('#genericBox').data("disableClose", true);
	Dropzone.autoDiscover = false;

	jQuery(document).ready(function () {
		bindUploadClose();

		jQuery("#myDropzone").dropzone({
			init: function () {
				var self = this;
				self.on("addedfile", function(file) {
					file.previewElement.addEventListener("click", function() {
						self.removeFile(file);
					});
				});
			},

			url: "<?php echo base_url('/uploadFile')?>",
			maxFilesize: <?php echo DROP_ZONE_FILE_MAX_SIZE?>,
			maxFiles: <?php echo DROP_ZONE_FILE_MAX_COUNT?>,
			autoProcessQueue: true,
		});


	});

	function bindUploadClose() {
		jQuery('#closeUpload').on('click', function() {
			//must turn off before close
			jQuery('#genericBox').data("disableClose", false);

			popupBox.hideImgBoxPopup(['#genericBox']);
		});
	}




</script>


