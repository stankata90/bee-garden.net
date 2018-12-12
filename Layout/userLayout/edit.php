<?php
/**
 * @var \Interfaces\pageController $this
 */
/** @var \DTO\dtoUser $objUser */
$objUser = $arrData['objUser'];
?>
    <div id="rightWarp">
        <fieldset id="myProfileEdit">
            <legend>Промяна на профил</legend>
            <form action="" method="post" enctype="multipart/form-data">

                <table>

                    <tr>
                        <td class="label">
                            Име:
                        </td>

                        <td>

                            <input type="text" name="firstName" value="<?=$objUser->getFirstName()?>" placeholder="Име"/>
                        </td>

                        <td rowspan="5" class="avatar" >
                            <?php
                            if( strlen($objUser->getAvatar())) {
                                $av = $objUser->getAvatar().'.'.$objUser->getAvatarExt();
                                $avtm = $objUser->getAvatar().'_thumbnail.'.$objUser->getAvatarExt();
                            } else {
                                $av = 'default.jpg';
                                $avtm = 'default.jpg';
                            }
                            ?>
                            <a href="/public/avatars/<?=$av?>" target="_blank" ><img  src="/public/avatars/<?=$avtm?>" /></a>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Фамилия:
                        </td>

                        <td>
                            <input type="text" name="lastName" value="<?=$objUser->getLastName()?>" placeholder="Фамилия" />
                        </td>

                    </tr>

                    <tr>
                        <td class="label">
                            <span>*</span>
                            Имейл адрес:
                        </td>
                        <td>
                            <input type="email" name="email" value="<?=$objUser->getEmail()?>" placeholder="example@abv.bg" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Години:
                        </td>
                        <td>


                            <input type="number" name="age" value="<?=$objUser->getAge()?>" placeholder="18" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Пол:
                        </td>
                        <td>
                            <input type="radio" name="sex" value="0" id="sexMale" <?=($objUser->getSex()=='0')?'checked':false?> />
                            <label for="sexMale" >Мъж</label>
                            <input type="radio" name="sex" value="1" id="sexFemale" <?=($objUser->getSex()=='1')?'checked':false?>  />
                            <label for="sexFemale" >Жена</label>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Уеб Сайт:
                        </td>
                        <td>
                            <input type="url" name='web' value="<?=$objUser->getWeb()?>" placeholder="https://example.com" />
                        </td>

                        <td class="avatar" >


                            <input type="file" name="avatarFile" value="Качи Аватар" class="file"/>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Нова Парола:
                        </td>

                        <td colspan="2">
                            <input type="password" name="new_password" value="" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            Повтори Паролата:
                        </td>

                        <td colspan="2">
                            <input type="password" name="renew_password" value="" />
                        </td>
                    </tr>

                    <tr>
                        <td class="label">
                            <span>*</span>
                            Текуща Парола:
                        </td>

                        <td colspan="2">
                            <input type="password" name='password' value="" />
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"  class="submit">
                            <input type="submit" name="save" value="Запиши Проените" />
                            <input type="reset" name="save" value="Анулирай Проените" />
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
