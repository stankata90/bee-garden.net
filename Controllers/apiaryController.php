<?php
namespace Controllers;
use DTO\dtoApiary;
use Interfaces\pageController;
use Models\apiaryModels;

class apiaryController extends pageController
{

    function list() {
        $objApiaryModels = new apiaryModels( $this->getFrontEngine() );

        $arrMenu = array(
            array('url' => 'apiary/new'),
//            array('url' => 'hive/new'),
//            array('url' => 'queen/new'),
//            array('url' => 'visit/new'),
//            array('url' => 'yield/new'),
//            array('url' => 'disease/new'),
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrData['objApiary'] = $objApiaryModels->list();
        $arrPage = array(
            'Layout/leftMenu',
            'list'
        );
        $this->getViewEngine()->layout( $arrPage,  $arrData  );
    }

    function new() {

        try {
            if (isset($_POST['type']) && $_POST['type'] == 'apiaryNew') {

                $_POST = array_map( 'my_striptags', $_POST );
                $_POST = array_map( 'my_htmlspecialchars', $_POST );
                $_POST = array_map( 'my_trim', $_POST );

                $arrData = [];
                $api_name = $_POST['name']??'';
                $api_location = $_POST['location']??NULL;

                if( mb_strlen($api_name) < 3 ) {
                    throw new \Exception( 'Името на пчелина трябва да е с минимална дължина от 3 символа!', '100' );
                } else if( mb_strlen( $api_name ) > 25 ) {
                    throw new \Exception( 'Името на пчелина трябва да е с максимална дължина от 25 символа! (Не се препоръчват толкова дълги имена)', '101' );
                }

                if( $api_location != NULL && mb_strlen( $api_location ) > 50 ) {
                    throw new \Exception( 'Локацията на пчелина трябва да е с максимална дължина от 50 символа!', '102' );
                }

                $arrData['api_name'] = $api_name;
                $arrData['api_location'] = $api_location;

                $objApiary = new apiaryModels( $this->getFrontEngine() );
                $id_new = $objApiary->new( $arrData );
                $this->getViewEngine()->redirect( '/apiary/list/' );

            }
        } catch ( \Exception $e ) {
            $this->getFrontEngine()->setErrorEngine( $e );
        }

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrPage = array(
            'Layout/leftMenu',
            'new'
        );
        $this->getViewEngine()->layout( $arrPage, $arrData );
    }

    function view() {

        if ( $this->getFrontEngine()->getParameter() == null  AND !intval( $this->getFrontEngine()->getParameter() ) ) {
            $this->getViewEngine()->redirect( "/apiary/list");
        }

        $apiary_id = intval( $this->getFrontEngine()->getParameter() );
        $apiModels = new apiaryModels( $this->getFrontEngine() );

        /** @var dtoApiary $objApiary */
        $objApiary = $apiModels->fetchOne( $apiary_id );

        if( $objApiary->getUserId() != $this->getFrontEngine()->getObjUser()->getUserId() ) {
            $this->getViewEngine()->redirect( "/apiary/list");
        }

        try {
            $a = 1;
        } catch( \Exception $e ) {
            $this->getFrontEngine()->setErrorEngine( $e );
        }

        $arrMenu = array(
            array('url' => 'apiary/edit', 'param' => $apiary_id ),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['objApiary'] = $objApiary;
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrPage = array(
            'Layout/leftMenu',
            'view'
        );
        $this->getViewEngine()->layout( $arrPage, $arrData );
    }

    function edit() {

        if ( $this->getFrontEngine()->getParameter() == null AND !intval( $this->getFrontEngine()->getParameter() ) ) {
            $this->getViewEngine()->redirect( "/apiary/list");
        }


        $apiary_id = intval( $this->getFrontEngine()->getParameter() );
        $apiModels = new apiaryModels( $this->getFrontEngine() );

        /** @var dtoApiary $objApiary */
        $objApiary = $apiModels->fetchOne( $apiary_id );

        if( $objApiary->getUserId() != $this->getFrontEngine()->getObjUser()->getUserId() ) {
            $this->getViewEngine()->redirect( "/apiary/list");
        }

        $arrData = [];
        try {
            if (isset($_POST['type']) && $_POST['type'] == 'apiaryEdit') {

                $_POST = array_map( 'my_striptags', $_POST );
                $_POST = array_map( 'my_htmlspecialchars', $_POST );
                $_POST = array_map( 'my_trim', $_POST );

                $name = $_POST['name']??'';
                $location = $_POST['location']??NULL;

                if( mb_strlen( $name ) < 3 ) {
                    throw new \Exception( 'Името на пчелина трябва да е с минимална дължина от 3 символа!', '100' );
                } else if( mb_strlen( $name ) > 25 ) {
                    throw new \Exception( 'Името на пчелина трябва да е с максимална дължина от 25 символа! (Не се препоръчват толкова дълги имена)', '101' );
                }

                if( $location != NULL && mb_strlen( $location ) > 50 ) {
                    throw new \Exception( 'Локацията на пчелина трябва да е с максимална дължина от 50 символа!', '102' );
                }

                $arrData['name'] = $name;
                $arrData['location'] = $location;
                $arrData['apiary_id'] = $apiary_id;

                $apiModels->edit( $arrData );

                $this->getViewEngine()->successMessage('Успешно записани промени.');
                $this->getViewEngine()->redirect( '/apiary/view/' .  $apiary_id );

            }
        } catch ( \Exception $e ) {
            $this->getFrontEngine()->setErrorEngine( $e );
        }

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new' ),
            array('url' => 'queen/new' ),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrData['objApiary'] = $objApiary;
        $arrPage = array(
            'Layout/leftMenu',
            'edit'
        );
        $this->getViewEngine()->layout( $arrPage, $arrData );
    }

    function delete() {

        $_GET = array_map( 'my_striptags', $_GET );
        $_GET = array_map( 'my_htmlspecialchars', $_GET );
        $_GET = array_map( 'my_trim', $_GET );

        $redirect = $_GET['redirect'] ?? '/list';

        $arrId = explode(',', $this->getFrontEngine()->getParameter() );
        $objModel = new apiaryModels( $this->getFrontEngine() );

        for( $i=0; $i<count( $arrId ); $i++ ) {

            /** @var dtoApiary $objApiary */
            $objApiary = $objModel->fetchOne( $arrId[$i] );
            if( $objApiary && $objApiary->getUserId() == $this->getFrontEngine()->getObjUser()->getUserId() ) {
                $objModel->delteOne( $objApiary->getApiaryId() );
            }
        }
        $this->getViewEngine()->redirect( '/' . $this->getFrontEngine()->getController() . $redirect );
    }

    function multiEdit() {

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new'),
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrPage = array(
            'Layout/leftMenu',
            'multiEdit'
        );
        $this->getViewEngine()->layout( $arrPage,$arrData );
    }

    function multiDelete() {
        if( false ) {

            $action = $_POST['action'] ?? '';
            $redirect = $_POST['redirect'] ?? '/list';

            $objModel = new apiaryModels( $this->getFrontEngine() );

            switch ($action ) {
                case 'delete':
                        if( is_array( $_POST['apiary_id'] ) ) {
                            for ( $i = 0; $i < count( $_POST['apiary_id'] ); $i++ ) {

                                /** @var dtoApiary $objApiary */
                                $objApiary = $objModel->fetchOne( $_POST['apiary_id'][$i] );
                                if( $objApiary && $objApiary->getUserId() == $this->getFrontEngine()->getObjUser()->getUserId() ) {
                                    $objModel->delteOne( $objApiary->getApiaryId() );

                                }
                            }
                        }
                    break;
            }

            $this->getViewEngine()->redirect( '/' . $this->getFrontEngine()->getController() . $redirect );
        }

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrPage = array(
            'Layout/leftMenu',
            'multiDelete'
        );
        $this->getViewEngine()->layout( $arrPage,$arrData );
    }

}
