<?php
    /** @var \Interfaces\pageController $this */
    /** @var \DTO\dtoApiary $objApiary */
    $objApiary = $arrData['objApiary'];
?>
    <div id="rightWarp">
        <fieldset id="apiaryEdit">
            <legend>Промяна Пчелин ( <?=$objApiary->getApiaryName()?> )</legend>
            <form action="" method="post" >
                <input type="hidden" name="type" value="apiaryEdit" />

                <table>
                    <tr>
                        <td><span>*</span> Име за пчелина</td>
                        <td><input type="text" name="name" value="<?=$objApiary->getApiaryName()?>" /></td>
                    </tr>
                    <tr>
                        <td>Локацията на пчелина</td>
                        <td><input type="text" name="location" value="<?=$objApiary->getLocation()?>"/></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit_apiaryEdit" value="Направи Промените" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>