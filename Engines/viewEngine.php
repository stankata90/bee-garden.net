<?php

namespace Engines;

class viewEngine
{
    /** @var frontEngine */
    private $frontEngine;

    private $arrHrefButtons;

    /** viewEngine constructor. @param frontEngine $frontEngine */
    function __construct(frontEngine $frontEngine )
    {
        $this->setFrontEngine( $frontEngine );

        $this->arrHrefButtons = array(

            'user/register' => array('url' => 'user/register', 'label' => 'Регистрация', 'title' => 'Регистрация на нов потребител', 'icon'  => 'save',),
            'user/login' => array('url' => 'user/login', 'label' => 'Вход', 'title' => 'Вход в системата', 'icon'  => 'log-in',),
            'user/logout' => array('url' => 'user/logout', 'label' => 'Изход', 'title' => 'Изход от системата', 'icon'  => 'log-out',),
            'user/edit' => array('url' => 'user/edit', 'label' => 'Промяна', 'title' => 'Промяна профил', 'icon'  => 'settings',),
            'user/view' => array('url' => 'user/view', 'label' => 'Профил', 'title' => 'Преглед профил', 'icon'  => 'file-text',),

            'apiary/list' => array('url' => 'apiary/list', 'label' => 'Пчелини', 'title' => 'Списък Пчелини', 'icon'  => 'image' ),
            'apiary/view' => array('url' => 'apiary/view', 'label' => 'Пчелин', 'title' => 'Преглед Пчелин', 'icon'  => 'plus-circle',),
            'apiary/new' => array('url' => 'apiary/new', 'label' => 'Пчелин', 'title' => 'Нов Пчелин', 'icon'  => 'plus-circle',),
            'apiary/edit' => array('url' => 'apiary/edit', 'label' => 'Промени', 'title' => 'Промени Пчелин', 'icon' => 'edit'),
            'apiary/delete' => array('url' => 'apiary/delete', 'label' => 'Изтрий', 'title' => 'Изтрий Пчелин', 'icon' => 'trash'),

            'hive/new' => array('url' => 'hive/new', 'label' => 'Семейство', 'title' => 'Ново Семейство', 'icon' => 'plus-circle'),
            'hive/list' => array('url' => 'hive/list', 'label' => 'Семейства', 'title' => 'Списък Семейства', 'icon' => 'users'),

            'queen/new' => array('url' => 'queen/new', 'label' => 'Майка', 'title' => 'Нова Майка', 'icon' => 'plus-circle'),
            'queen/list' => array('url' => 'queen/list', 'label' => 'Майки', 'title' => 'Списък Майки', 'icon' => 'loader'),

            'visit/new' => array('url' => 'visit/new', 'label' => 'Преглед', 'title' => 'Нов Преглед', 'icon' => 'plus-circle'),
            'visit/list' => array('url' => 'visit/list', 'label' => 'Прегледи', 'title' => 'Списък Прегледи', 'icon' => 'search'),

            'yield/new' => array('url' => 'yield/new', 'label' => 'Добив', 'title' => 'Нов Добив', 'icon' => 'plus-circle'),
            'yield/list' => array('url' => 'yield/list', 'label' => 'Добиви', 'title' => 'Списък Добиви', 'icon' => 'truck'),

            'disease/new' => array('url' => 'disease/new', 'label' => 'Заболяване', 'title' => 'Ново Заболяване', 'icon' => 'plus-circle'),
            'disease/list' => array('url' => 'disease/list', 'label' => 'Заболяване', 'title' => 'Списък Заболявания', 'icon' => 'activity'),

            'list/list' => array('url' => 'list/list', 'label' => 'Списъци', 'title' => 'Моите Списъци', 'icon' => 'list'),
            'list/disease' => array('url' => 'list/disease', 'label' => 'Заболявания', 'title' => 'Списък Заболявания', 'icon' => 'list'),
            'list/observation' => array('url' => 'list/observation', 'label' => 'Наблюдения', 'title' => 'Списък Наблюдения', 'icon' => 'list'),
            'list/plugin' => array('url' => 'list/plugin', 'label' => 'Приставки', 'title' => 'Списък Приставки', 'icon' => 'list'),
            'list/hivesource' => array('url' => 'list/hivesource', 'label' => 'Отводка Източник', 'title' => 'Списък Отводка Източник', 'icon' => 'list'),
            'list/system' => array('url' => 'list/system', 'label' => 'Системи', 'title' => 'Списък Системи', 'icon' => 'list'),
            'list/treatment' => array('url' => 'list/treatment', 'label' => 'Третирания', 'title' => 'Списък Третирания', 'icon' => 'list'),
            'list/inspection' => array('url' => 'list/inspection', 'label' => 'Прегледи', 'title' => 'Списък Прегледи', 'icon' => 'list'),
            'list/queencolor' => array('url' => 'list/queencolor', 'label' => 'Майки Цветове', 'title' => 'Списък Майки Цветове', 'icon' => 'list'),
            'list/queentype' => array('url' => 'list/queentype', 'label' => 'Майки', 'title' => 'Списък Вид Майки', 'icon' => 'list')
        );
    }

    function getHrefButton( $url, $param='', $query='', $label='', $title='', $icon='', $onclick='' ) {
        $dirIcon = '/public/img/icons/';
        $extIcon = 'png';

        $fChar = my_substr( $url, 0, 1);
        if( $fChar == "/") {
            $url = my_substr( $url, 1, my_strlen($url) );
        }

        $lChar = my_substr( $url, my_strlen($url) -1, my_strlen( $url ) );
        if( $lChar == '/') {
            $url = my_substr( $url, 0,my_strlen($url) -1 );
        }

        if( array_key_exists( $url, $this->arrHrefButtons ) ) {
            $arrUrl = $this->arrHrefButtons[ $url ];
            $arrUrl['url'] = '/'. $arrUrl['url'] . '/';

            if( $label != '' ) {
                if( my_substr( $label, 0, 1) == '.' ) {
                    $arrUrl['label'] .= my_substr( $label, 1 , my_strlen( $label ) );
                } else {
                    $arrUrl['label'] = $label;
                }
            }
            if( $param != '' ) {
                $arrUrl['url'] .= $param;
            }
            if( $query != '' ) {
                $arrUrl['url'] .= "?" . $query;
            }
            if( $title != '' ) {
                if( my_substr( $title, 0, 1) == '+' ) {
                    $arrUrl['title'] .= my_substr( $title, 1 , my_strlen( $title ) );
                } else {
                    $arrUrl['title'] = $title;
                }
            }
            if( $onclick != '' ) {
                $arrUrl['onclick'] = "onclick=\"" . $onclick ."\"";
            } else {
                $arrUrl['onclick'] = '';
            }

            if( $icon != '' ) {
                $arrUrl['icon'] = $dirIcon . $icon . '.' . $extIcon;
            } else {
                $arrUrl['icon'] = $dirIcon . $arrUrl['icon'] . '.' . $extIcon;
            }

            return $arrUrl;
        } else {
            return false;
        }
    }

    function pageLeftMenu( $arr = [] ) : \Generator {
        foreach ( $arr as $url ) {
            yield $this->getHrefButton($url['url']??'',$url['param']??'',$url['query']??'',$url['label']??'',$url['title']??'',$url['icon']??'',$url['onclick']??'' );
        }
    }

    function layout( $arrLayout = [], $arrData = [] ) {

        require_once $this->getFrontEngine()->getDirLayout()."/header.php";

        if( count( $arrLayout ) ) {
            foreach ( $arrLayout as $fileLayout ) {
                $file = $this->getFrontEngine()->getDirLayout() . '/' . $this->getFrontEngine()->getController() . $this->getFrontEngine()->getDirLayout() . '/' . $fileLayout . 'Info.php';

                if (file_exists($file)) {
                    require_once $file;
                }
            }
        } else {
            $fileLayout = $this->getFrontEngine()->getDirLayout() . '/' . $this->getFrontEngine()->getController() . $this->getFrontEngine()->getDirLayout(). '/' . $this->getFrontEngine()->getAction() . 'Info.php';
            if ( file_exists( $fileLayout ) ) {

                require_once "$fileLayout";
            }
        }

        if( $this->getFrontEngine()->getErrorEngine() ) {
            require_once $this->getFrontEngine()->getDirLayout()."/errorMessage.php";
        }

        $this->successMessage();

        if( count( $arrLayout )) {
            foreach ( $arrLayout as $fileLayout ) {

                $file = $this->getFrontEngine()->getDirLayout() . '/' . $this->getFrontEngine()->getController() . $this->getFrontEngine()->getDirLayout(). '/' . $fileLayout . '.php';
                if ( file_exists( $file ) ) {
                    require_once $file;
                }
            }

        } else {

            $fileLayout = $this->getFrontEngine()->getDirLayout() . '/' . $this->getFrontEngine()->getController() . $this->getFrontEngine()->getDirLayout(). '/' . $this->getFrontEngine()->getAction() . '.php';
            if ( file_exists( $fileLayout ) ) {

                require_once "$fileLayout";
            }
        }

        require_once $this->getFrontEngine()->getDirLayout()."/footer.php";
    }

    function successMessage( $strMessage = '' ) {

        if( $strMessage != '' ) {
            if( !isset( $_SESSION['user']['successMessage'] ) ) {
                $_SESSION['user']['successMessage'] = $strMessage;
            }
        } else {
            if( isset( $_SESSION['user']['successMessage'] ) ) {
                require_once $this->frontEngine->getDirLayout() . "/successMessage.php";
                unset( $_SESSION['user']['successMessage'] );
            }
        }
    }

    function redirect( $page ) {
        header( "Location: $page" );
        exit();
    }

    /** @return mixed */
    public function getFrontEngine(): frontEngine
    {
        return $this->frontEngine;
    }

    /** @param mixed $frontEngine */
    private function setFrontEngine( frontEngine $frontEngine): void
    {
        $this->frontEngine = $frontEngine;
    }

}