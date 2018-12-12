<?php

namespace Models;

use DTO\dtoListType;
use Interfaces\rootModels;

class listModels extends rootModels
{
    function byId( int $id ) : ?dtoListType {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT
             *
            FROM
              `user_list_type`
            WHERE
            `list_type_id` = $id
            AND
            `user_id` = {$this->getFrontEngine()->getObjUser()->getUserId()}
        ");
        $query = $stmt->execute();
        $obj =  $query->fetchOne(dtoListType::class );
        return $obj ? $obj : null;
    }

    function byName( string $name, string $list ) : ?dtoListType {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT
              *
            FROM
              `user_list_type`
            WHERE
              `name` = :_name
              AND
              `list` = :_list
              AND
              `user_id` = {$this->getFrontEngine()->getObjUser()->getUserId()}
        ");
        $query = $stmt->execute( array(':_name' => $name, ':_list' => $list ) );
        $obj =  $query->fetchOne(dtoListType::class );
        return $obj ? $obj : null;
    }

    function new( string $name, string $description, string $list ) : void {

        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            INSERT INTO
            `user_list_type`
            ( 
              `name`,
              `description`,
              `list`,
              `user_id`
            )
            VALUES
            ( 
              :d_name,
              :d_description,
              :d_list,
              :d_user_id
            )
        ");

        $stmt->execute( array(
            ':d_name' => $name,
            ':d_description' => $description,
            ':d_list' => $list,
            ':d_user_id' => $this->getFrontEngine()->getObjUser()->getUserId()
        ) );
    }

    function edit( int $id, string $name, string $description, string $list ) : void {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            UPDATE
              `user_list_type`
            SET
              `name` = :_name,
              `description` = :_description,
              `list` = :_list
            WHERE
              `list_type_id` = $id
              AND
              `user_id` = ". $this->getFrontEngine()->getObjUser()->getUserId()
        );

        $stmt->execute( array(
            ':_name' => $name,
            ':_description' => $description,
            ':_list' => $list
        ) );
    }

    function delete( int $id ) : void {
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            DELETE FROM
              `user_list_type`
            WHERE
               `list_type_id` = $id
               AND
               `user_id` = " . $this->getFrontEngine()->getObjUser()->getUserId() ."
            LIMIT 1
        ");

        $stmt->execute();
    }

    function list( ?string $list, string $order = 'ASC' ) : \Generator {
        $qList = ( $list != null ) ? "AND `list` = :p_list" : null;

        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT
              *
            FROM
              `user_list_type`
            WHERE
              `user_id` = {$this->getFrontEngine()->getObjUser()->getUserId()}
              $qList
            ORDER BY
              `name` $order
        ");

        $query = $stmt->execute( ( $list != null  ? array( ':p_list' => $list) : array() ) );
       

        foreach( $query->fetch(dtoListType::class ) as $obj ) {
            yield $obj;
        }

    }
}