<div id="loginBox" class="shadowWrapper smallPopup">

    <div class="shadowLayer baseLayer">

    </div>


    <div class="baseLayer">

        <form name="loginForm" id="loginForm" action="/login" method="post">
            <div class="mainBox">
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
                    <h2>LOGIN TO ACCOUNT</h2>
                </div>
                <div class="ajaxNotice">
                    Loading...
                </div>
                <div class="registerFormBox">
                    <label>#Username/Email:</label>
                    <input name = "username" type="text" maxlength="30" placeholder="insert your email/username">
                    <label>#Password:</label>
                    <input name = "password" type="password" maxlength="30" placeholder="insert your password">

                    <div id="rememberme">
                        <input type="checkbox" id="remembermeChk">
                        <label for="remembermeChk">&nbsp;</label>
                        <label id="remembermeTx">Remember me</label>
                    </div>
                    <input name="rememberme" type="checkbox" hidden = "hidden" value="false">
                </div>
                <div class="registerFooter">
                    <ul>
                        <li>Need an Account? <a href="switchtosignin">Sign up</a></li>
                        <li>Forgot password? <a href="#">Retrieve</a></li>
                    </ul>

					<div class="captcha" id="RecaptchaField1"></div>

                    <button id="logInBtn" class="btn-submit btn-smallpop-submit" type="button">Sign in</button>

                    <button class="btn-reset btn-smallpop-cancel" type="reset">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="signupBox" class="shadowWrapper smallPopup">

    <div class="shadowLayer baseLayer">

    </div>


    <div class="baseLayer">
        <form name="registerForm" id="registerForm" action="/signup" method="post">
            <div class="mainBox">
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
                    <h2>CREATE AN ACCOUNT</h2>
                </div>
                <div class="ajaxNotice">
                    Loading...
                </div>
                <div class="registerFormBox">

                    <label>#Email:</label>
                    <input name = "email" type="text" maxlength="30" placeholder="insert your email">
                    <label>#Username:</label>
                    <input name = "username" type="text" maxlength="30" placeholder="username should ...">
                    <label>#Password:</label>
                    <input name = "password" type="password" maxlength="30" placeholder="insert your password">
                    <label>#Confirm Password:</label>
                    <input name = "passwordConfirm" type="password" maxlength="30" placeholder="confirm your password">
                </div>
                <div class="registerFooter">
                    <ul>
                        <li>Have an Account? <a href="switchtosignup">Sign in</a></li>
                    </ul>

					<div class="captcha" id="RecaptchaField2"></div>

                    <button id="signUpBtn" class="btn-submit btn-smallpop-submit" type="button">Sign up</button>
                    <button class="btn-reset btn-smallpop-cancel" type="reset">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

