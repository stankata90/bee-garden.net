<?php /** @var \Engines\viewEngine $this */
/** @var \DTO\dtoListType $objModel */
$list = ( isset( $_GET['list'] ) == true && array_key_exists( $_GET['list'], $arrData['arrList'] ) ? "list=". $_GET['list'] : null );


?>
    <div id="rightWarp">
        <fieldset id="myLists">
            <legend>
                Моите Списъци ( <a href="/list/list/?mode=new&<?=$list?>" title="Нов Запис">Добави</a> )
            </legend>

            <table class="listList">
                <tr>
                    <th><a href="?by=name" title="Подреди по име">Име</a></th>
                    <th>Описание</th>
                    <th>Лист</th>

                    <th>Създаден</th>
                    <th>Редактиран</th>
                    <th>Действие</th>
                </tr>
                <?php foreach (  $arrData['objModel'] as $objModel ): ?>
                <tr>
                    <td>
                        <a href="/list/list/<?=$objModel->getListTypeId()?>?mode=edit" title="Промени '.<?=$objModel->getName()?>" >
                            <?=$objModel->getName();?>
                        </a>
                    </td>
                    <td>
                        <span title="<?=$objModel->getDescription()?>">
                             <?=my_strabb( $objModel->getDescription(),20 )?>
                        </span>
                    </td>
                    <td>
                        <a href="?list=<?=$objModel->getList()?>">
                        <?= $arrData['arrList'][$objModel->getList()]?>
                        </a>

                    </td>
                    <td>
                        <?=$objModel->getDateCreate()?>
                    </td>
                    <td>
                        <?=$objModel->getDateEdit()?>
                    </td>
                    <td>
                        <?php
                            $onclick = "return confirm('Сигорни ли сте че искате да изтриете заболяване ". $objModel->getName() ." ?')";
                        ?>
                        <a href="/list/list/<?=$objModel->getListTypeId()?>?mode=delete&amp;redirect=<?=urlencode( "/list/list/?$list" ); ?>"  onclick="<?=$onclick?>" title='Изтрий заболяване( <?=$objModel->getName()?> ) !'>
                            <img src="/public/img/icons/trash.png" alt="" />
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </table>

        </fieldset>
    </div>
</div>