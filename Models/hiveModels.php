<?php

namespace Models;

use DTO\dtoHive;
use Interfaces\rootModels;

class hiveModels extends rootModels
{
    function hiveListNewHive() {
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();
        $bfQuery = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT 
              * 
            FROM 
              `apiary` AS a
            
            LEFT JOIN
              `mm_hive_apiary` as ha
            USING ( `apiary_id` )
            
            INNER JOIN
              `hive` as h
            USING ( `hive_id` )
            
            WHERE 
              a.`user_id` =  $user_id 
            
            ORDER BY
              a.`apiary_name` ASC,     
              h.`name` ASC     
        ");



        $afQuery = $bfQuery->execute();

        foreach( $afQuery->fetch( dtoHive::class) as $obj ) {
            yield $obj;
        }
    }

    function newHive( $arrData = [] ) {

        $this->getFrontEngine()->getObjDataBase()->beginTransaction();
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();

        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `hive`
            ( `name`, `user_id`, `description`, `date_install` )
              VALUES 
            (
              :_name, :_user_id, :_description, :_date_install
            )
        ");

        $stmt->execute( array(
            ':_name' => $arrData['hiveName'],
            ':_user_id' => $user_id,
            ':_description' => $arrData['hiveDescription'],
            ':_date_install' => $arrData['hiveDate']
        ) );
        $hive_id = $this->getFrontEngine()->getObjDataBase()->lastInserId();

        // SYSTEM
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_hive_system`
            ( `hive_id`, `system_id` )
              VALUES
            ( :_hive_id, :_system_id )
        ");

        $stmt->execute( array(
            ':_hive_id' => $hive_id,
            ':_system_id' => $arrData['hiveSystem']
        ) );

        // APIARY
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_hive_apiary`
            ( `hive_id`, `apiary_id` )
              VALUES 
            (
              :_hive_id, :_apiary_id
            )
        ");

        $stmt->execute( array(
            ':_hive_id' => $hive_id,
            ':_apiary_id' => $arrData['hiveApiary']
        ) );

        // SOURCE
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_hive_source`
            ( `hive_id`, `source_id` )
              values 
            ( :_hive_id, :_source_id)
        ");

        $stmt->execute( array(
            ':_hive_id' => $hive_id,
            ':_source_id' => $arrData['hiveSource']
        ) );

        // Queen
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `queen`
            (  `name`, `hive_id`, `date_born` )
              VALUES 
            ( :_name, :_hive_id, :_date )
        ");

        $stmt->execute( array(
            ':_name' => $arrData['queenName'],
            ':_hive_id' => $hive_id,
            ':_date' => $arrData['queenDate']
        ) );
        $queen_id = $this->getFrontEngine()->getObjDataBase()->lastInserId();

        // Queen Hive
        $stmt = $this->getFrontEngine()->getObjDataBase()->query( "
            INSERT INTO
              `mm_queen_hive`
            ( `queen_id`, `hive_id` )
              VALUES
            ( $queen_id, $hive_id )
        ");

        $stmt->execute();

        // Queen Color
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_queen_color`
            ( `queen_id`, `color_id` )
              VALUES
            ( :_queen_id, :_color_id )
        ");

        $stmt->execute( array(
            ':_queen_id' => $queen_id,
            ':_color_id' => $arrData['queenColor']
        ) );

        // Queen Type
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_queen_type`
            ( `queen_id`, `type_id` )
              VALUES 
            ( :_queen_id, :_type_id )
        ");

        $stmt->execute( array(
            ':_queen_id' => $queen_id,
            ':_type_id' => $arrData['queenType']
        ) );

        // Hive Parent
        $stmt = $this->getFrontEngine()->getObjDataBase()->query( "
            INSERT INTO
              `mm_hive_parent`
            ( `hive_id`, `parent_id` )
              VALUES
            ( :_hive_id, :_parent_id )
        ");

        if( is_array( $arrData['hiveList'] ) ) {
            foreach ( $arrData['hiveList'] as $hiveList ) {
                $stmt->execute( array(
                    ':_hive_id' => $hive_id,
                    ':_parent_id' => $hiveList
                ) );
            }
        }

        // Hive Plugin
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
              `mm_hive_plugin`
            ( `hive_id`, `plugin_id`, `user_id`, `date_install` )
              VALUES
            ( $hive_id, :_plugin_id, $user_id, :_date )
        ");

        if( is_array( $arrData['hivePlugin'] ) ) {
            foreach ( $arrData['hivePlugin'] as $hivePlugin ) {
                $stmt->execute( array(
                    ':_plugin_id' => $hivePlugin,
                    ':_date' => $arrData['hiveDate']
                ) );
            }
        }

        // Increment Hive Sum
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            UPDATE
              `apiary`
            SET
              `hive_sum` = hive_sum + 1
            WHERE
              `apiary_id` = :_apiary_id
        ");

        $stmt->execute(
            array ( ':_apiary_id' => $arrData['hiveApiary'] )
        );

        $this->getFrontEngine()->getObjDataBase()->commit();
    }
}