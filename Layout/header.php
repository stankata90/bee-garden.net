<?php /** @var \Engines\viewEngine $this */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>Пчелна градина</title>

        <link rel="stylesheet" type="text/css" href="/public/css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/public/css/font.css" media="screen" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>

    <body>

        <div id="header">
            <h2 class="contentWidth"><a href="/home"> Пчелна градина</a></h2>
            <div class="topWellcom contentWidth">

                <?php if( $this->frontEngine->getObjUser() ) : $view = $this->getHrefButton(  'user/view', '','', $this->frontEngine->getObjUser()->getUserName(), 'Преглед '.$this->frontEngine->getObjUser()->getUserName() ); ?>
                    Добре дошли,  <b><a href="<?=$view['url']?>" title="<?=$view['title']?>"><?=$view['label']?></a> !</b>
                <?php endif; ?>

                <div class='barry'></div>
                <div class='clear'></div>
            </div>
            <hr />
            <div class="topNav contentWidth" >

                <?php
                    if( !$this->frontEngine->getObjUser() ) {
                        $arr = array(
                            array('url' => 'user/login'),
                            array('url' => 'user/register')
                        );
                    } else {
                        $arr = array(
                            array('url' => 'apiary/list'),
                            array('url' => 'hive/list'),
                            array('url' => 'queen/list'),
                            array('url' => 'visit/list'),
                            array('url' => 'yield/list'),
                            array('url' => 'disease/list'),
                            array('url' => 'user/logout')
                        );
                    } ?>

                  <?php  foreach ( $arr as $value ) : $url = $this->getHrefButton(  $value['url'] ); ?>

                    <a href="<?=$url['url']?>" title="<?=$url['title']?>">
                        <img src="<?=$url['icon']?>" alt="<?=$url['title']?>" >
                        <?=$url['label']?>
                    </a>

                    <?php endforeach; ?>
            </div>

            <hr/>
        </div>


        <div id="page">
