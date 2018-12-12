<?php
namespace Controllers;

use DTO\dtoListType;
use Interfaces\pageController;
use Models\listModels;

class listController extends pageController
{
    const page_url = "/list/list/";

    const name_minLen = 1;
    const name_maxLen = 50;
    const desc_maxLen = 2000;

    const message_access = 'Отказан достъп !';

    const message_error_name_len = 'Името трябва да е в диапазона от '. self::name_minLen .' до '. self::name_maxLen .' символа !';
    const message_error_name_exist = 'Името "%s" съществува в списък "%s" !';
    const message_error_desc_len = 'Описанието не трябва да е в диапазона от 0 до '. self::desc_maxLen .' символа !';
    const message_error_list_exist = 'Списъкъ "%s" не съществува !';

    const message_success_add = 'Успешно добавихте "%s" в списък "%s" !';
    const message_success_edit = 'Успешно променихте "%s" в списък "%s" !';
    const message_success_delete = 'Успешно изтрихте "%s" от списък "%s" !';

    private $objModel;
    private $arrMenu;
    private $arrList;

    public function list() {

        $this->objModel = new listModels( $this->getFrontEngine() );
        $this->arrMenu = array(
            array('url' => self::page_url ),
            array('url' => self::page_url, 'query' => 'list=disease', 'label' => 'Заболявания'),
            array('url' => self::page_url, 'query' => 'list=queentype', 'label' => 'Майки'),
            array('url' => self::page_url, 'query' => 'list=queencolor', 'label' => 'Майки Цветове'),
            array('url' => self::page_url, 'query' => 'list=observation', 'label' => 'Наблюдения'),
            array('url' => self::page_url, 'query' => 'list=inspection', 'label' => 'Преглед'),
            array('url' => self::page_url, 'query' => 'list=plugin', 'label' => 'Плъгин'),
            array('url' => self::page_url, 'query' => 'list=hivesource', 'label' => 'Отводка Източник'),
            array('url' => self::page_url, 'query' => 'list=system', 'label' => 'Системи'),
            array('url' => self::page_url, 'query' => 'list=treatment', 'label' => 'Третирания')
        );
        $this->arrList = array(
            'disease' => 'Заболявания',
            'queentype' => 'Майки',
            'queencolor' => 'Майки Цветове',
            'observation' => 'Наблюдения',
            'inspection' => 'Преглед',
            'plugin' => 'Плъгин',
            'hivesource' => 'О-ка Източник',
            'system' => 'Системи',
            'treatment' => 'Третирания'
        );

        $mode = $_GET['mode'] ?? null;
        $list = $_GET['list'] ?? null;

        switch ( $mode ) {
            case "new":
                $layout = "listForm";

                if( isset( $_POST['type' ] ) && $_POST['type'] == 'listForm' ) {

                    try {
                        $_POST = array_map( "my_addslashes", $_POST );
                        $_POST = array_map( "my_trim", $_POST );

                        $redirect = $_POST['redirect'] ?? self::page_url;
                        $name = $_POST['name'];
                        $list = $_POST['list'];
                        $desc = $_POST['description'];

                        /** @var dtoListType $objList */
                        $objList = $this->objModel->byName( $name, $list );

                        if( $objList ) {
                            $message = sprintf( self::message_error_name_exist, $name, $this->arrList[ $list ] );
                            throw new \Exception( $message );
                        }

                        if( my_strlen( $name ) < self::name_minLen OR  my_strlen( $name ) > self::name_maxLen ) {
                            throw new \Exception( self::message_error_name_len );
                        }

                        if( my_strlen( $desc ) > self::desc_maxLen ) {
                            throw new \Exception( self::message_error_desc_len );
                        }

                        if( !array_key_exists( $list, $this->arrList ) ) {
                            $message = sprintf( self::message_error_list_exist, $this->arrList[ $list ] );
                            throw new \Exception( $message );
                        }

                        $this->objModel->new( $name, $desc, $list );

                        $message = sprintf(self::message_success_add, $name, $this->arrList[ $list ] );
                        $this->getViewEngine()->successMessage( $message );
                        $this->getViewEngine()->redirect( $redirect );
                    } catch( \Exception  $e ) {
                        $this->getFrontEngine()->setErrorEngine( $e );
                    }
                }

                break;

            case "edit":
                $layout = "listForm";

                /** @var dtoListType $objList */
                $objList = $this->objModel->byId( $this->getFrontEngine()->getParameter() );

                if( !$objList ) {
                    $this->getViewEngine()->successMessage( self::message_access );
                    $this->getViewEngine()->redirect( self::page_url );
                }

                if( isset( $_POST['type' ] ) && $_POST['type'] == 'listForm' ) {
                    try {
                        $_POST = array_map("my_addslashes", $_POST);
                        $_POST = array_map("my_trim", $_POST);

                        $name = $_POST['name'];
                        $list = $_POST['list'];
                        $desc = $_POST['description'];

                        $objMatch = $this->objModel->byName( $name, $list );

                        if( my_strlen( $name ) < self::name_minLen OR  my_strlen( $name ) > self::name_maxLen ) {
                            $message = sprintf( self::message_error_name_len );
                            throw new \Exception(  $message );
                        }

                        if( $name != $objList->getName() || $list != $objList->getList() ) {
                            if( $objMatch ) {
                                $message = sprintf( self::message_error_name_exist, $name,  $this->arrList[ $list ] );
                                throw new \Exception( $message );
                            }
                        }

                        if( !array_key_exists( $list, $this->arrList ) ) {
                            $message = sprintf( self::message_error_list_exist );
                            throw new \Exception( $message );
                        }

                        if( my_strlen( $desc ) > self::desc_maxLen ) {
                            $message = sprintf( self::message_error_desc_len );
                            throw new \Exception( $message );
                        }

                        $this->objModel->edit( $objList->getListTypeId(), $name, $desc, $list );
                        $message = sprintf( self::message_success_edit, $name, $this->arrList[ $list ] );

                        $this->getViewEngine()->successMessage( $message );
                        $this->getViewEngine()->redirect( $_SERVER['REQUEST_URI'] );

                    } catch( \Exception $e) {
                        $this->getFrontEngine()->setErrorEngine( $e );
                    }
                }

                if( $objList ) {
                    $arrData['objDisease'] = $objList;
                }

                break;

            case "delete":
                $layout = "";
                $redirect = $_GET['redirect'] ?? self::page_url;

                /** @var dtoListType $objList */
                $objList = $this->objModel->byId( $this->getFrontEngine()->getParameter() );

                if( !$objList ) {
                    $this->getViewEngine()->successMessage( self::message_access );
                    $this->getViewEngine()->redirect( self::page_url );
                }

                $this->objModel->delete( $this->getFrontEngine()->getParameter() );
                $message = sprintf( self::message_success_delete, $objList->getName(), $this->arrList[ $objList->getList() ] );
                $this->getViewEngine()->successMessage( $message );
                $this->getViewEngine()->redirect( urldecode( $redirect ) );

                break;

            default:
                $layout = "listList";
                $arrData['objModel'] = $this->objModel->list($list);

                break;
        }

        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $this->arrMenu );
        $arrData['arrList'] = $this->arrList;

        $arrPage = array(
            'listMenu',
            $layout
        );
        $this->getViewEngine()->layout( $arrPage,  $arrData  );
    }
}