<?php
    /**
     * @var \Engines\viewEngine $this
     * @var \DTO\dtoApiary $dtoApiary
     * @var \DTO\dtoListType $dtoQueenColor
     * @var \DTO\dtoListType $dtoQueenType
     * @var \DTO\dtoListType $dtoHiveSystem
     * @var \DTO\dtoListType $dtoHivePlugin
     * @var \DTO\dtoListType $dtoHiveSource
     * @var \DTO\dtoHive $dtoHiveList
     */

    $arrTd = [];
    foreach ( $arrData['hiveList'] as $dtoHiveList ) {
        $arrTd[ $dtoHiveList->apiary_name ]['apiary']['hives'] = $dtoHiveList->hive_sum;
        $arrTd[ $dtoHiveList->apiary_name ]['hives'][] = "<label for='hive_$dtoHiveList->hive_id' ><input type='checkbox' name='hiveList[]' value='$dtoHiveList->hive_id' id='hive_$dtoHiveList->hive_id' ". ( in_array( $dtoHiveList->hive_id, $arrData['formData']['hiveList'] ) ? "checked='checked'" : null) ." >".$dtoHiveList->name."</label>";
    }

    $table = "<table>";
    foreach ( $arrTd as $key => $value ) {
        $table .= "<tr>";
            $table .= "<th>Пчелин - $key ( {$value['apiary']['hives']} ) </th>";
        $table .= "</tr>";

        $table .= "<tr>";
            $table .= "<td>";
            foreach ( $value['hives'] as $tdval ) {
                $table .= $tdval;
            }
            $table .= "</td>";
        $table .= "</tr>";
    }
?>

<div id="rightWarp">
    <fieldset id="hiveNew">
        <legend>Ново Семейство</legend>
        <form action="" method="post" >
            <input type="hidden" name="type" value="hiveNew" />

            <table border="0">
                <tr>
                    <th colspan="4">
                        Кошер / Пчелин
                    </th>
                </tr>

                <tr>
                    <td>
                        <label for="hiveName" ><span class="markerRed">*</span> Име</label>
                    </td>
                    <td>
                        <input type="text" name="hiveName" value="<?=$arrData['formData']['hiveName']?>" id="hiveName" onchange="queenNameChange(this)" autofocus />
                    </td>
                    <td colspan="2" class="pluginname" >
                        <?php $urlPluginTypeList = $this->getHrefButton('list/list', '', 'list=plugin', 'Плъгини', 'Кликни за редакция на списъците' ) ?>
                        <a href="<?=$urlPluginTypeList['url']?>"  target="_blank"><?=$urlPluginTypeList['label']?></a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="hiveDate" ><span class="markerRed">*</span> Дата</label>
                    </td>
                    <td>
                        <input type="date" name="hiveDate" id="hiveDate" value="<?=$arrData['formData']['hiveDate']?>" onchange="queenDateChange(this)"/>
                    </td>

                    <td colspan="2" rowspan="5" class="plugin" id="pluginTd" >
                        <div id="plugin">
                            <?php foreach ( $arrData['hivePlugin'] as $dtoHivePlugin ) : ?>
                                <input type="checkbox" name="hivePlugin[]" value="<?=$dtoHivePlugin->getListTypeId()?>" id="plugin_id<?=$dtoHivePlugin->getListTypeId()?>" <?=( in_array( $dtoHivePlugin->getListTypeId(), $arrData['formData']['hivePlugin'] ) ? "checked=\"checked\"": null)?>  />
                                <label for="plugin_id<?=$dtoHivePlugin->getListTypeId()?>" title="<?=$dtoHivePlugin->getDescription()?>" ><?=$dtoHivePlugin->getName()?></label>
                                <br />
                            <?php endforeach ?>
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <label for="hiveSystem">
                            <span class="markerRed">*</span>
                            <?php $urlSystemList = $this->getHrefButton('list/list', '', 'list=system', 'Система', 'Кликни за редакция на списъците' ) ?>
                            <a href="<?=$urlSystemList['url']?>" title="<?=$urlSystemList['title']?>" target="_blank"><?=$urlSystemList['label']?></a>
                        </label>
                    </td>
                    <td>
                        <select name="hiveSystem" id="hiveSystem" >
                            <option value="0" >...</option>
                            <?php foreach ( $arrData['hiveSystems'] as $dtoHiveSystem ) : ?>
                                <option value="<?=$dtoHiveSystem->getListTypeId()?>" title="<?=$dtoHiveSystem->getDescription()?>" <?=($arrData['formData']['hiveSystem'] == $dtoHiveSystem->getListTypeId() ? "selected='selected'" : null )?> ><?=$dtoHiveSystem->getName()?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="hiveApiary">
                            <span class="markerRed">*</span>
                            <?php $urlApiary = $this->getHrefButton('apiary/list' ) ?>
                            <a href="<?=$urlApiary['url']?>" title="<?=$urlApiary['title']?>" target="_blank"><?=$urlApiary['label']?></a>
                        </label>
                    </td>

                    <td>
                        <select name="hiveApiary" id="hiveApiary" >
                            <option value="0" >...</option>
                            <?php foreach ( $arrData['apiary'] as $dtoApiary ) : ?>
                                <option value="<?=$dtoApiary->getApiaryId()?>" <?=($arrData['formData']['hiveApiary'] == $dtoApiary->getApiaryId() ? "selected='selected'" : null )?> ><?=$dtoApiary->getApiaryName()?> ( <?=$dtoApiary->getHiveSum()?> )</option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="hiveSource">
                            <span class="markerRed">*</span>
                            <?php $urlHiveSourceList = $this->getHrefButton('list/list', '', 'list=hivesource', 'Отводка източник', 'Кликни за редакция на списъците' ) ?>
                            <a href="<?=$urlHiveSourceList['url']?>" title="<?=$urlHiveSourceList['title']?>" target="_blank"><?=$urlHiveSourceList['label']?></a>
                        </label>
                    </td>

                    <td>
                        <select name="hiveSource" id="hiveSource" >
                            <option value="0" >...</option>
                            <?php foreach ( $arrData['hiveSource'] as $dtoHiveSource ) : ?>
                                <option value="<?=$dtoHiveSource->getListTypeId()?>" title="<?=$dtoHiveSource->getDescription()?>" <?=($arrData['formData']['hiveSource'] == $dtoHiveSource->getListTypeId() ? "selected='selected'" : null )?> ><?=$dtoHiveSource->getName()?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr id="hiveSourceGroupTr">
                    <td>
                        <span class="markerRed">*</span> Зборна Отводка ?
                    </td>
                    <td>

                        <label for="hiveSourceGroupYes" >
                            <input type="radio" name="hiveSourceGroup" value="1" id="hiveSourceGroupYes" onchange="writeHive()" <?=( $arrData['formData']['hiveSourceGroup'] == 1 ? "checked=\"checked\"" : null )?> />
                            Да
                        </label>

                        <label for="hiveSourceGroupNo" >
                            <input type="radio" name="hiveSourceGroup" value="0" id="hiveSourceGroupNo" onchange="deleteHive()" <?=( $arrData['formData']['hiveSourceGroup'] == 0 ? "checked=\"checked\"" : null )?> />
                            Не
                        </label>
                    </td>
                </tr>


                <tr>
                    <th colspan="4">
                        Майка
                    </th>
                </tr>

                <tr>
                    <td>
                        <label for="queenName"><span class="markerRed">*</span> Име</label>
                    </td>

                    <td>
                        <input type="text" name='queenName' value="<?=$arrData['formData']['queenName']?>" id="queenName" />
                    </td>

                    <td>
                        <label for="queenColor">
                            <span class="markerRed">*</span>
                            <?php $urlQueenColorList = $this->getHrefButton('list/list', '', 'list=queencolor', 'Майка Цвят', 'Кликни за редакция на списъците' ) ?>
                            <a href="<?=$urlQueenColorList['url']?>" title="<?=$urlQueenColorList['title']?>" target="_blank"><?=$urlQueenColorList['label']?></a>
                        </label>
                    </td>

                    <td>
                        <label>
                            <select name="queenColor" id="queenColor" >
                                <option value="0" >...</option>
                                <?php foreach ( $arrData['queenColor'] as $dtoQueenColor ) : ?>
                                    <option value="<?=$dtoQueenColor->getListTypeId()?>" <?=($arrData['formData']['queenColor'] == $dtoQueenColor->getListTypeId() ? "selected='selected'" : null )?> ><?=$dtoQueenColor->getName()?></option>
                                <?php endforeach ?>
                            </select>
                        </label>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="queenDate"><span class="markerRed">*</span>  Година</label>
                    </td>
                    <td>
                        <input type="date" name="queenDate" value="<?=$arrData['formData']['queenDate']?>" id="queenDate" />
                    </td>

                    <td>
                        <label for="queenType" >
                            <span class="markerRed">*</span>
                            <?php $urlQueenTypeList = $this->getHrefButton('list/list', '', 'list=queentype', 'Майка Тип', 'Кликни за редакция на списъците' ) ?>
                            <a href="<?=$urlQueenTypeList['url']?>" title="<?=$urlQueenTypeList['title']?>" target="_blank" ><?=$urlQueenTypeList['label']?></a>
                        </label>
                    </td>

                    <td>
                        <select name="queenType" id="queenType" >
                            <option value="0" >...</option>
                            <?php foreach ( $arrData['queenType'] as $dtoQueentype ) : ?>
                                <option value="<?=$dtoQueentype->getListTypeId()?>" <?=($arrData['formData']['queenType'] == $dtoQueentype->getListTypeId() ? "selected='selected'" : null )?> ><?=$dtoQueentype->getName()?></option>
                            <?php endforeach ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th colspan="4">
                        Допълнително
                    </th>
                </tr>

                <tr>
                    <td>
                        <label for="hiveDescription">Описание</label>
                    </td>

                    <td colspan="4">
                        <textarea name="hiveDescription" id="hiveDescription" ><?=$arrData['formData']['hiveDescription']?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="4"><input type="submit" name="submit_apiaryEdit" value="Направи Промените" /></td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
</div>

<script type="text/javascript">
    function  queenNameChange( e ) {
        document.getElementById("queenName").value = "Q-" + e.value;
    }
    function  queenDateChange( e ) {
        document.getElementById("queenDate").value =  e.value;
    }

    if( document.getElementById("hiveSourceGroupYes").checked == true ) {
        writeHive();
    }

    function writeHive() {
        var new_tr = document.createElement('tr');
        new_tr.setAttribute("id", "hiveList");
        new_tr.insertCell(0).innerHTML = "<?=$table?>";
        new_tr.childNodes[0].setAttribute("colspan", "4");
        insertAfter(document.getElementById("hiveSourceGroupTr"), new_tr);
    }
    function deleteHive() {
        var element = document.getElementById("hiveList");
        element.parentNode.removeChild(element);
    }

    function insertAfter(target, el) {
        if( !target.nextSibling )
            target.parentNode.appendChild( el );
        else
            target.parentNode.insertBefore( el, target.nextSibling );
    }

</script>