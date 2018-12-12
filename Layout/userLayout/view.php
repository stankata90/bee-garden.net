<?php
/**
 * @var \Interfaces\pageController $this
 */
/** @var \DTO\dtoUser $objUser */
$objUser = $arrData['objUser'];
?>
    <div id="rightWarp">
        <fieldset id="myProfileView">
            <legend>Детайли за  <?=$objUser->getUserName()?></legend>

            <?php
            if( strlen($objUser->getAvatar())) {
                $av = $objUser->getAvatar().'.'.$objUser->getAvatarExt();
                $av_thumb = $objUser->getAvatar().'_thumbnail.'.$objUser->getAvatarExt();
            } else {
                $av = 'default.jpg';
                $av_thumb = 'default.jpg';
            }
            ?>

            <table>
                <tr>
                    <td class="avatar" colspan="3">
                        <a href="/public/avatars/<?=$av?>" target="_blank" ><img  src="/public/avatars/<?=$av_thumb?>" /></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h1>
                            <?=$objUser->getFirstName()?>
                            <?=$objUser->getLastName()?>
                        </h1>
                    </td>
                </tr>

                <tr>
                    <td>
                        <h1>
                            <?=$objUser->getEmail()?>
                        </h1>
                    </td>
                    <td>
                        <h1>
                            <?=$objUser->getAge()??'-'?> г.
                        </h1>

                    </td>
                    <td>
                        <h1>
                            пол:
                            <?php $arrSex = array('0'=>'мъж', '1'=>'жена');
                            echo($objUser->getSex()=='')?'-':$arrSex[$objUser->getSex()];?>
                        </h1>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <h2>
                            <a href="<?=$objUser->getWeb()?>"><?=$objUser->getWeb()?></a>
                        </h2>
                    </td>
                </tr>

            </table>
        </fieldset>
    </div>
</div>