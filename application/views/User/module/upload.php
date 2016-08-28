<script src="<?php echo base_url('/resource/js/lib/dropzone.min.js') ?>"/>
<!--<link rel='stylesheet' href='../resource/theme/default/css/basic.min.css'>-->
<link rel='stylesheet' href='<?php echo base_url('/resource/theme/default/css/dropzone.min.css') ?>'>

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
	<form class="dropzone" id="myDropzone">
		<div class="dz-message" data-dz-message>
			<img src="<?php echo base_url('/resource/theme/default/img/upload_imgs21.png') ?>"/>
			<div>Choose files or Drag them here</div>
		</div>
	</form>
</div>

<div id="btnSection">
	<button id="submitUpload" class="btn-submit" type="button">Upload</button>
	<button id="closeUpload" class="btn-reset" type="button">Cancel</button>
</div>

<script>
	//must here
	var DZ_FILELIST = new Array;
	var DZ_RM_DUP = false;

	jQuery(document).ready(function () {
		jQuery('#genericBox').data("disableClose", true);

		Dropzone.autoDiscover = false;

		bindUploadClose();

		bindSubmit();

		var i = 0;

		jQuery("#myDropzone").dropzone({
//			addRemoveLinks: true,
			init: function () {
				var self = this;

				self.on("addedfile", function (file) {
					//prevent duplicate file
					if (self.files.length) {
						var _i, _len;
						for (_i = 0, _len = self.files.length; _i < _len - 1; _i++) // -1 to exclude current file
						{
							if (self.files[_i].name === file.name && self.files[_i].size === file.size && self.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
								DZ_RM_DUP = true;
								self.removeFile(file);

							}
						}
					}

					//add double click event for removing img
					file.previewElement.addEventListener("dblclick", function () {
						DZ_RM_DUP = false;
						self.removeFile(file);
					});
				});

				self.on("success", function (file, serverFileName) {
					DZ_FILELIST[i] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": i, "last_date": file.lastModifiedDate.toString()};
					file.serverFileName = serverFileName;

					i++;
				});

				self.on("removedfile", function (file) {
					//file not in the DZ_FILELIST, just a duplicate file
					if (DZ_RM_DUP) {
						return;
					}

					var rmvFile = "";
					var f;
					for (f = 0; f < DZ_FILELIST.length; f++) {
						//if just remove duplicate file, DZ_FILELIST[f] doesn't have serverFileName.
						if (DZ_FILELIST[f].fileName == file.name && DZ_FILELIST[f].last_date == file.lastModifiedDate.toString()) {
							rmvFile = DZ_FILELIST[f].serverFileName;

							DZ_FILELIST.splice(f, 1);
						}
					}

					//delete on server
					if (rmvFile) {
						console.log('deleting server file' + rmvFile.toString());
						jQuery.ajax({
							method: 'POST',
							url: '<?php echo base_url('/upload/delete')?>',
							data: {rmvFile: rmvFile},
							dataType: 'json'
						});
					}
				});

			},


			url: "<?php echo base_url('/upload/file')?>",
			maxFilesize: <?php echo DROP_ZONE_FILE_MAX_SIZE?>,
			maxFiles: <?php echo DROP_ZONE_FILE_MAX_COUNT?>,
			autoProcessQueue: true,
		});


	});

	function bindUploadClose() {
		var closeBtn = jQuery('#closeUpload');

		closeBtn.off('click').on('click', function () {
			if (closeBtn.prop("disabled")) {
				return;
			}

			//must turn off before close
			jQuery('#genericBox').data("disableClose", false);

			popupBox.hideImgBoxPopup(['#genericBox']);
		});
	}

	function onSubmit() {
		var submitBtn = jQuery('#submitUpload');

		submitBtn.off('click').on('click', function () {


		});
	}

	function bindSubmit() {
		jQuery('#submitUpload').off('click').on('click', function () {
			var closeBtn = jQuery("#closeUpload");
			closeBtn.prop("disabled", true);

			console.log(JSON.stringify(DZ_FILELIST));

			//		popupBox.hideImgBoxPopup(['#genericBox']);

			jQuery.ajax({
				method: 'POST',
				url: '<?php echo base_url('/upload/complete')?>',
				data: {file_list: DZ_FILELIST},
				dataType: 'json',
				async: 'false',
				success: function (data) {
					console.error(JSON.stringify(data));
					console.error('asd');

				},
				error: function (data) {
//					popupBox._popupMsgBanner("error", "Server error, please retry again.");
					console.error(data);

				}
			});

			closeBtn.prop("disabled", false);

		});


	}


</script>


<!--http://stackoverflow.com/questions/24859005/dropzone-js-how-to-change-file-name-before-uploading-to-folder-->