<div id='pAuthorization' class="contentWidth">
    <div id="centerWarp">
        <fieldset id='register'>
            <legend>Регистрация</legend>
            <form method="post" action="/user/register" >
                <input type="hidden" name="type" value="register" />
                <table>
                    <tr>
                        <td><label for='user_name'><span class='markerRed'>*</span> Име</label></td>
                        <td><input type="text" name="user_name" id='user_name' value="<?=$arrData['user_name']?>" /></td>
                    </tr>

                    <tr>
                        <td><label for='user_password'><span class='markerRed'>*</span> Парола</label></td>
                        <td><input type="password" name="user_password" id='user_password' value="<?=$arrData['user_password']?>" /></td>
                    </tr>

                    <tr>
                        <td><label for='user_password_re'><span class='markerRed'>*</span> Повтори паролата</label></td>
                        <td><input type="password" name="user_password_re" id='user_password_re' value="<?=$arrData['user_password_re']?>" /></td>
                    </tr>

                    <tr>
                        <td><label for='user_email'><span class='markerRed'>*</span> E-mail</label></td>
                        <td> <input type="email" name="user_email" id='user_email' value="<?=$arrData['user_email']?>" /></td>
                    </tr>

                    <tr>
                        <td><label for='user_email_re'><span class='markerRed'>*</span> Повтори E-mail</label></td>
                        <td><input type="email" name="user_email_re" id='user_email_re' value="<?=$arrData['user_email_re']?>" /></td>
                    </tr>

                    <tr>
                        <td colspan="2"><input type="submit" name="submit_reg" id='submit_reg' value="Регистрирай" /></td>
                    </tr>

                </table>
            </form>
        </fieldset>
    </div>
</div>