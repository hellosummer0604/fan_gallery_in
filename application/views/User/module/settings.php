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
		<input name="primary_headline" type="text" maxlength="30" placeholder="insert your primary headline">
		<label>Second headline:</label>
		<input name="second_headline" type="text" maxlength="30" placeholder="insert your second headline">
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

	}

	var submitUpdate = function() {
		validateUpdate();


	}

	var cancelPopup = function () {
		popupBox.hideImgBoxPopup(['#genericBox']);
	}

</script>