<div id="imgBox" class="shadowWrapper">

    <span id="authorBox">ssss</span>

    <div class="shadowLayer baseLayer">

    </div>

    <div class="baseLayer">
        <form action="/publish" method="post">
            <!--				<div class="closeBanner">
                                <div class="closeButton">This is </div>
                            </div>-->
			<span class="popupImg" id="imgTitle">
				<input type="text" id="imgTitle" name="imgTitle">
			</span>

            <div class="popupImg" id="popImgBox">

            </div>

            <div class="popupImg" id="popImgText">
                <span class="innerBox">
                    <div id="imgAuthorTags" class="buttonDiv itag"><a href="#">North Fan</a></div>
                    <span id="imgTags" class="buttonDiv"></span>
                </span>
                &nbsp;&nbsp;
                <span class="warning">Click Tags to remove</span>
                <br>
                <span class="innerBox" id="imgTagNameAutoComplete">
                    <input class="imgTagName typeahead" type="text" maxlength="30" placeholder="Tagging this photo"/>
                    <button type="button" class="addImgTag">Add Tag</button>
                </span>
<!--                &nbsp;&nbsp;&nbsp;-->
<!--                <span>[Tagging this photo]</span>-->

                <div class="innerBox" id="imgText">
                    <textarea placeholder="请在此输入内容..."></textarea>
                </div>
                <div class="innerBox">
                    <button class="btn-submit" type="button">Submit</button>
                    <button class="btn-reset" type="reset">Cancel</button>
                </div>
            </div>

            <!--		<div class="popupImg" id="popImgDescription">
                            EXIF info here
                    </div>-->
    </div>
</div>

<div id="uploadBox" class="shadowWrapper">

    <div class="shadowLayer baseLayer">

    </div>


    <div class="baseLayer">

        <div class="closeBanner">
            <div class="closeButton">Esc</div>
        </div>

        <div class="popupImg">
            <h2>Upload Photo</h2>
        </div>

    </div>
</div>


<!--		<div id="generalPopup">
				
		</div>-->

</form>
<div class="headerNavBackground">

</div>
<nav class="headerNav">
    <span class="float_left">North Gallery</span>
    <span class="float_right font_size_14">Log in</span>
    <span class="float_right font_size_14" id="upload">Sign up</span>
</nav>