<?php
namespace Engines;

use Database\PDODatabase;
use DTO\dtoUser;

class userEngine
{
    private $database;
    private $objUser;

    function __construct( PDODatabase $objDataBase )
    {
        $this->database = $objDataBase;
    }

    public function isLogin() : ?dtoUser
    {
       if( isset( $_SESSION['user']['key'] ) ) {

           $stmt_user = $this->database->query( "
              SELECT
                `user_id`,
                `user_name`,
                `password`,
                `key`
              
              FROM
                `user` 
              
              WHERE `key` = :login_key
              " );

           $execute = $stmt_user->execute(
               array(
                   'login_key' => $_SESSION['user']['key']
               )
           );

           $this->objUser = $execute->fetchOne( dtoUser::class );
       }

        return $this->objUser;
    }

}