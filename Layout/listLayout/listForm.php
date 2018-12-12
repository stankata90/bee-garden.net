<?php
/** @var \Engines\viewEngine $this */
/** @var \DTO\dtoListType $objDisease */

    $listUrl = ( isset( $_GET['list'] ) == true && array_key_exists( $_GET['list'], $arrData['arrList'] ) ? "&amp;list=". $_GET['list'] : null );
    if( isset( $arrData['objDisease'] ) ){

        $objDisease = $arrData['objDisease'];
        $name = $objDisease->getName();
        $description = $objDisease->getDescription();
        $list = $objDisease->getList();

    } else {

        $name = $_POST['name'] ?? '' ;
        $description = $_POST['description'] ?? '' ;
        $list = $_GET['list'] ?? 'null' ;

    }

?>
    <div id="rightWarp">
        <fieldset id="myLists">
            <legend>
                Моите Списъци ( <a href="/list/list/?mode=new<?=$listUrl?>" title="Нов Запис">Добави</a> )
            </legend>
            <form action="" method="post" >
                <input type="hidden" name="type" value="listForm" />
                <input type="hidden" name="redirect" value="/list/list/?<?=$listUrl?>" />
                <table class="listForm">
                    <tr>
                        <th colspan="2">
                            <h4>Нов Запис</h4>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            Име
                        </td>
                        <td>
                            <input type="text" name="name" value="<?=$name?>" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Списък
                        </td>
                        <td>
                            <select name="list" >
                                <option value="" >...</option>
                                <?php foreach ( $arrData['arrList'] as $key => $value ): ?>
                                    <option value="<?=$key?>" <?=($key==$list)?"selected='selected'":null?> ><?=$value?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Описание
                        </td>
                        <td>
                            <textarea name="description" ><?=$description?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Запази" />
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>