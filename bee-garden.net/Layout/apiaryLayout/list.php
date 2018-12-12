<?php
/**
 * @var \DTO\dtoApiary $objApiary
 */
?>
<script language="JavaScript">
    function toggle(source) {
        checkboxes = document.getElementsByName('apiary_id[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function mf() {
        var form = document.getElementById("mf") || null;
        var select = document.getElementById("mfSelect").value;

        switch(select) {
            case "delete":
            form.action = "/apiary/multidelete";
                break;

            case "edit":
                form.action = "/apiary/multiedit";
                break;
        }
        form.submit();
    }

    function go(url) {
        window.location.href = url;
    }

    $(document).keydown(function(e) {
        isI = false;
        if(e.which == 73 ) {
            isI = true
            url = '/apiary/new';
        }
    });

    $(document).keyup(function(e) {
        if( e.which == 16 && isI ) {
           go(url);
        }
    });
</script>

    <div id="rightWarp">
        <fieldset id="apiaryList">
            <legend>Пчелини</legend>

            <form id="mf" action="" method="post" >
                <input type="hidden" value="/list" />

                Когато има отметка:
                <select id="mfSelect" name="action" onchange="mf()" >
                    <option></option>
                    <option value="delete">Изтрий</option>
                    <option value="edit">Промени</option>
                </select>

                <table>
                    <tr>
                        <th>
                            <input type="checkbox" onClick="toggle(this)" /> Пчелин
                        </th>

                        <th>
                            Семейства
                        </th>

                        <th>
                            Локация
                        </th>

                        <th>
                            Заболявания
                        </th>

                        <th>
                        </th>
                    </tr>
                    <?php foreach ( $arrData['objApiary'] as $objApiary ) :
                        $hiveSum = ( $objApiary->getHiveSum() == 0 ) ? "-" : $objApiary->getHiveSum();
                        $location = ( $objApiary->getLocation() == NULL || $objApiary->getLocation() == '' ) ? "-" : $objApiary->getLocation();
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="apiary_id[]" value="<?=$objApiary->getApiaryId()?>" />
                            <a href="/apiary/view/<?=$objApiary->getApiaryId()?>" title="Детайли за ( <?=$objApiary->getApiaryName()?> )"><?=$objApiary->getApiaryName()?></a>
                        </td>

                        <td>
                            <?=$hiveSum?>
                        </td>

                        <td>
                            <?=$location?>
                        </td>

                        <td>
                            -
                        </td>

                        <td>
                            <a href="/apiary/edit/<?=$objApiary->getApiaryId()?>" title="промяна пчелин ( <?=$objApiary->getApiaryName()?> ) ">
                                <img src="/public/img/icons/edit.png" width="16" />
                            </a>

                            <a href="/apiary/delete/<?=$objApiary->getApiaryId()?>?redirect=/list" onclick="return confirm('Сигорни ли сте че искате да изтриете пчелин <?=$objApiary->getApiaryName()?> ?')" title='Изтриване пчелин ( <?=$objApiary->getApiaryName()?> )!'>
                                <img src="/public/img/icons/trash.png" width="16" />
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </table>
            </form>

        </fieldset>
    </div>
</div>

