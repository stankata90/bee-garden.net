<?php

namespace Controllers;

use Interfaces\pageController;
use Models\apiaryModels;
use Models\hiveModels;
use Models\listModels;

class hiveController extends pageController
{
    public function new() {
        $objApiaryModels = new apiaryModels( $this->getFrontEngine() );
        $objHiveModels = new hiveModels( $this->getFrontEngine() );
        $objListModels = new listModels( $this->getFrontEngine() );

        $_POST = array_map( "my_striptags", $_POST );

        $formData['hiveName'] = $_POST['hiveName']??null;
        $formData['hiveDate'] = $_POST['hiveDate']??null;
        $formData['hiveSystem'] = $_POST['hiveSystem']??null;
        $formData['hiveApiary'] = $_POST['hiveApiary']??null;
        $formData['hiveSource'] = $_POST['hiveSource']??null;
        $formData['hivePlugin'] = $_POST['hivePlugin']??array();
        $formData['hiveSourceGroup'] = $_POST['hiveSourceGroup']??null;
        $formData['hiveList'] = $_POST['hiveList']??array();


        $formData['queenName'] = $_POST['queenName']??null;
        $formData['queenColor'] = $_POST['queenColor']??null;
        $formData['queenDate'] = $_POST['queenDate']??null;
        $formData['queenType'] = $_POST['queenType']??null;
        $formData['hiveDescription'] = $_POST['hiveDescription']??null;


        try {

            if( isset($_POST['type'] ) && $_POST['type'] == 'hiveNew' ) {

                if( my_is_specsym( $formData['hiveName'] ) ) {
                    throw new \Exception( 'Името за кошер съдържа забранени символи' );
                }

                $objHiveModels->newHive( $formData );

            }
        } catch ( \Exception $e ) {
            $this->getFrontEngine()->setErrorEngine( $e );
        }

        $arrData['apiary'] = $objApiaryModels->list( "`apiary_id`, `apiary_name`, `hive_sum`" );
        $arrData['queenColor'] = $objListModels->list( "queencolor" );
        $arrData['queenType'] = $objListModels->list( "queentype" );
        $arrData['hiveSystems'] = $objListModels->list( "system" );
        $arrData['hiveSource'] = $objListModels->list( "hivesource" );
        $arrData['hivePlugin'] = $objListModels->list( "plugin" );
        $arrData['hiveList'] = $objHiveModels->hiveListNewHive();

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
        $arrData['formData'] = $formData;
        $arrLayout = array(
            'Layout/leftMenu',
            'new'
        );

        $this->getViewEngine()->layout( $arrLayout, $arrData );
    }

    public function list() {
        $objHiveModels = new hiveModels( $this->getFrontEngine() );
        $objListModels = new listModels( $this->getFrontEngine() );

        $arrMenu = array(
            array('url' => 'apiary/new'),
            array('url' => 'hive/new'),
            array('url' => 'queen/new'),
            array('url' => 'visit/new'),
            array('url' => 'yield/new'),
            array('url' => 'disease/new')
        );
        $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );

        $arrLayout = array(
            'Layout/leftMenu',
            'new'
        );
        $this->getViewEngine()->layout( $arrLayout, $arrData );
    }
}