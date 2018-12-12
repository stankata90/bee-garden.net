<?php

namespace Models;

use DTO\dtoApiary;
use Interfaces\rootModels;

class apiaryModels extends rootModels
{
    public function new( $arrData = [] ) : int {

        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO `apiary`
            ( `apiary_name`, `location`, `user_id` )
            VALUES
            ( :api_name, :api_location, :user_id )
        ");

        $stmt->execute( array(
            ':api_name' => $arrData['api_name'],
            ':api_location' => $arrData['api_location'],
            ':user_id' => $this->getFrontEngine()->getObjUser()->getUserId() ) );

        return $this->getFrontEngine()->getObjDataBase()->lastInserId();
    }

    public function edit( $arrData = [] ) :void {
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            UPDATE
                `apiary`
            SET
            `apiary_name` = :apiname,
            `location` = :apilocation
            
            WHERE
            `user_id` = $user_id
              AND
            `apiary_id` = {$arrData['apiary_id']}
        ");

        $stmt->execute(
            array(
                ':apiname' => $arrData['name'],
                ':apilocation' => $arrData['location']
            )
        );
    }

    public function list( string $column = "*" ) : \Generator {

        $bfQuery = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT $column FROM `apiary` WHERE `user_id` =  ". $this->getFrontEngine()->getObjUser()->getUserId() );
        $afQuery = $bfQuery->execute();

        foreach( $afQuery->fetch( dtoApiary::class ) as $obj ) {
            yield $obj;
        }
    }

    public function fetchOne($intId )  {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query( "SELECT * FROM `apiary` WHERE `apiary_id` = :apiary_id" );
        $query = $stmt->execute( array( ':apiary_id' => $intId ) );

        return $query->fetchOne( dtoApiary::class );
    }

    public function delteOne( $intId ) {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("DELETE FROM `apiary` WHERE `apiary_id` = :apiary_id LIMIT 1");
        $query = $stmt->execute( array( ':apiary_id' => $intId ) );

        return $query;
    }
}