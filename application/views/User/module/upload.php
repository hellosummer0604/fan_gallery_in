<script src="<?php echo base_url('/resource/js/lib/dropzone.min.js') ?>"/>
<link rel='stylesheet' href='<?php echo base_url('/resource/theme/default/css/dropzone.min.css') ?>'>
<style type="text/css">
	#successList {
		text-align: left;
		padding-left: 30px;
		margin-bottom: 30px;
		margin-top: -18px;
		min-height:1px;
	}

	#successList ul{
		list-style: none;
	}

	#successList .chkMark:after {
		content: attr(data-content) '\2714';
		color: rgb(0, 171, 230);
	}
</style>


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
<div class="ajaxNotice">
	Loading...
</div>
<div id="uploadDropbox">
	<form class="dropzone" id="myDropzone">
		<div class="dz-message" data-dz-message>
			<img src="<?php echo base_url('/resource/theme/default/img/upload_imgs21.png') ?>"/>
			<div>Choose files or Drag them here<br>Double Click to remove</div>
		</div>
	</form>
</div>

<div id="btnSection">
	<button id="submitUpload" class="btn-submit" type="button">Upload</button>&nbsp;
	<button id="closeUpload" class="btn-reset" type="button">Close</button>
</div>
<div id="successList">
	<ul>
<!--		<li>asdasdbhasudbasf.jpg <span class="chkMark"></span></li>-->
<!--		<li>sadaisdhasodoiasd.png <span class="chkMark"></span></li>-->
<!--		<li>asdbaspdhasdojasd.jpg <span class="chkMark"></span></li>-->
	</ul>
</div>
<script>
	//must here
	var DZ_DROPZONE = null;

	jQuery(document).ready(function () {
		jQuery('#genericBox').data("disableClose", true);

		Dropzone.autoDiscover = false;

		bindUploadClose();

		bindSubmit();

		var i = 0;

		//todo still have bug
		jQuery("#myDropzone").dropzone({
			init: function () {
				var self = this;
				DZ_DROPZONE = this;

				self.on("addedfile", function (file) {
					//prevent duplicate file
					if (self.files.length) {
						var _i, _len;
						for (_i = 0, _len = self.files.length; _i < _len - 1; _i++) // -1 to exclude current file
						{
							if (self.files[_i].name === file.name && self.files[_i].size === file.size && self.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
								self.removeFile(file);
							}
						}
					}

					//add double click event for removing img
					file.previewElement.addEventListener("dblclick", function () {
						deleteOnServer(file.serverFileName);

						self.removeFile(file);
					});
				});

				self.on("success", function (file, serverFileName) {
					file.serverFileName = serverFileName;
//					console.log('add img: ' + serverFileName);
				});

				self.on("removedfile", function (file) {
//					console.log('deleting file' + file.toString());
				});

			},


			url: "<?php echo base_url('/upload/file')?>",
			maxFilesize: <?php echo DROP_ZONE_FILE_MAX_SIZE?>,
			maxFiles: <?php echo DROP_ZONE_FILE_MAX_COUNT?>,
			autoProcessQueue: true,
			acceptedFiles: "image/*",
		});


	});

	function bindUploadClose() {
		var closeBtn = jQuery('#closeUpload');

		closeBtn.off('click').on('click', function () {
			if (closeBtn.prop("disabled")) {
				return;
			}

			closeUploadBox();
		});
	}

	function closeUploadBox() {
		//must turn off before close
		jQuery('#genericBox').data("disableClose", false);

		popupBox.hideImgBoxPopup(['#genericBox']);

		//delete uploaded tmp files
		deleteAllUploads();
	}

	function bindSubmit() {
		jQuery('#submitUpload').off('click').on('click', function () {
			popupBox._popupMsgBanner("notice", "Uploading...");

			jQuery("#closeUpload").hide();
			jQuery("#submitUpload").hide();

			var tempData = {'fileList': JSON.stringify(DZ_DROPZONE.files)};
			jQuery.ajax({
				method: 'POST',
				url: '<?php echo base_url('/upload/complete')?>',
				data: tempData,
				dataType: 'json',
				success: function (data) {
					if (data.result) {
						popupBox._popupMsgBanner("success", data.msg + ", redirecting to photo repository.");
						//
						data.data.forEach(function(enrty) {
							jQuery('#successList ul').append('<li>'+ enrty + '&nbsp;&nbsp;<span class="chkMark"></span><li>');
						});

					} else {
						popupBox._popupMsgBanner("warning", data);
					}
					//enable cancel button
					jQuery("#closeUpload").show();
					jQuery("#submitUpload").show();
				},
				error: function (data) {
					popupBox._popupMsgBanner("error", "Server error, please reload this page and retry again.");
					console.error(data);
					//enable cancel button
					jQuery("#closeUpload").show();
					jQuery("#submitUpload").show();
				}
			});


		});


	}
	
	function deleteOnServer(serverFileNames) {
		if (typeof serverFileNames == "undefined") {
			return;
		}

//		console.log('deleting server file' + serverFileNames);
		jQuery.ajax({
			method: 'POST',
			url: '<?php echo base_url('/upload/delete')?>',
			data: {rmvFile: serverFileNames},
			dataType: 'json'
		});
	}

	function deleteAllUploads() {
		jQuery.ajax({
			method: 'POST',
			url: '<?php echo base_url('/upload/deleteAll')?>',
			data: '',
			dataType: 'text'
		});
	}


</script>