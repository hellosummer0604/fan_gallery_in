<form name="settingsForm" id="settingsForm" action="/account/login" method="post">
	<div class="colorBanner">
		<table cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</tbody></table>
	</div>
	<div class="titleBox">
		<h2>SETTINGS</h2>
	</div>
	<div class="ajaxNotice" style="display: none;"></div>
	<div class="popupFormBox">
		<label>Primary headline:</label>
		<input id="primary_headline" name="primary_headline" type="text" maxlength="50" placeholder="insert your primary headline" value="<?php echo $user->getPrimaryHeadline()?>">
		<label>Second headline:</label>
		<textarea rows="5" id="second_headline" name="second_headline" type="text" maxlength="50" placeholder="insert your second headline"><?php echo $user->getSecondHeadline()?></textarea>
	</div>
	<div class="popupFooter">
		<button id="uploadSetting" class="btn-submit" type="button">Update</button>

		<button id="closeSetting" class="btn-reset" type="button">Close</button>
	</div>
</form>
<script>
	jQuery(document).ready(function () {
		jQuery('#uploadSetting').off('click').on('click', function () {
			submitUpdate();
		});

		jQuery('#closeSetting').off('click').on('click', function () {
			cancelPopup();
		});
	});

	var validateUpdate = function() {
		var result = true;

//		var primary_headline = jQuery('#primary_headline').val().trim();
//		var second_headline = jQuery('#second_headline').val().trim();
//
//		var regex = new RegExp("[\u4e00-\u9eff_a-zA-Z0-9_]{1,50}");
//
//		if ((primary_headline.length > 0 && !regex.test(primary_headline))
//			|| (second_headline.length > 0 && !regex.test(second_headline))) {
//			popupBox._popupMsgBanner("warning", "Please insert headlines");
//			result = false;
//		}

		return result;
	}

	var submitUpdate = function() {
		if (validateUpdate()) {
			var primary_headline = jQuery('#primary_headline').val().trim();
			var second_headline = jQuery('#second_headline').val().trim();

			var tempData = {'first': primary_headline, 'second': second_headline};

			jQuery.ajax({
				method: 'POST',
				url: '<?php echo base_url('/settings')?>',
				data: tempData,
				dataType: 'json',
				success: function (data) {
					if (data.result) {
						popupBox._popupMsgBanner("success", data.msg);
					} else {
						popupBox._popupMsgBanner("error", data.errorMsg);
					}
				},
				error: function (data) {
					popupBox._popupMsgBanner("error", "Server error, please reload this page and retry again.");
				}
			});

		}
	}

	var cancelPopup = function () {
		popupBox.hideImgBoxPopup(['#genericBox']);
	}

</script>