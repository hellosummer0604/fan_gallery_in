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
		<input id="primary_headline" name="primary_headline" type="text" maxlength="50" placeholder="insert your primary headline">
		<label>Second headline:</label>
		<input id="second_headline" name="second_headline" type="text" maxlength="50" placeholder="insert your second headline">
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
			popupBox._popupMsgBanner('close');

		}
	}

	var cancelPopup = function () {
		popupBox.hideImgBoxPopup(['#genericBox']);
	}

</script>