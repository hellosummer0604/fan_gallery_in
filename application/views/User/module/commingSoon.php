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
	<h2>COMMING SOON</h2>
</div>
<div class="ajaxNotice" style="display: none;"></div>
<div class="popupFormBox">
	<label>Sorry, still working on this popup</label>
</div>
<div class="popupFooter">
	<button id="closeSetting" class="btn-submit" type="button">Close</button>
</div>

<script>
	jQuery(document).ready(function () {
		jQuery('#closeSetting').off('click').on('click', function () {
			cancelPopup();
		});
	});

	var cancelPopup = function () {
		popupBox.hideImgBoxPopup(['#genericBox']);
	}

</script>