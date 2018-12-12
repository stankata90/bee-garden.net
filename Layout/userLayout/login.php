<div id='pAuthorization' class="contentWidth">
    <div id="centerWarp">
        <fieldset id='login' >
            <legend>Вход</legend>

            <form method="post" action="/user/login">

                <input type="hidden" name="type" value="login" />
                    <table>
                        <tr>
                            <td>
                                <label for='user_email'>Потребителско име / E-mail</label>
                            </td>
                            <td>
                                <input type="text" name="user_email" id='user_email' value="" placeholder="stankov@abv.bg" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for='user_password' >Парола</label>
                            </td>
                            <td>
                                <input type="password" name="user_password" id='user_password' value="" placeholder="0000" />
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit_login" id='submit_login' value="Вход" />
                            </td>
                        </tr>
                    </table>
                </form>
        </fieldset>
    </div>
</div>