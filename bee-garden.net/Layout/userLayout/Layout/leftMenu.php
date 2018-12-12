<div id="pProfile" class="contentWidth">
    <div id="leftWarp">
        <fieldset id="menu">
            <legend>Меню Профил</legend>
            <ul>
                <?php foreach ( $arrData['leftMenu'] as $arrUrl ) : ?>
                    <li>
                        <a href="<?=$arrUrl['url']?>" title="<?=$arrUrl['title']?>" <?=$arrUrl['onclick']?> >
                            <img src="<?=$arrUrl['icon']?>" alt="" />
                            <span>
                            <?=$arrUrl['label']?>
                        </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </fieldset>
    </div>