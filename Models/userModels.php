<?php

namespace Models;

use DTO\dtoApiary;
use Interfaces\rootModels;

use DTO\dtoUser;

class userModels extends rootModels {

    function register( $data ) {

        $password = password_hash( $data['user_password'], PASSWORD_DEFAULT );
        $time = strtotime( date("Y-m-d H:i:s") );
        $login_key = password_hash( password_hash( $data['user_password'], PASSWORD_DEFAULT ).$time, PASSWORD_DEFAULT );


        $stmt_user = $this->getFrontEngine()->getObjDataBase()->query("
                    INSERT INTO
                      `user` 
                    (
                      `user_name`,
                      `password`,
                      `email`,
                      `key`
                    )
                    VALUES 
                    (
                      :user_name,
                      :user_password,
                      :email,
                      :user_key
                    )
        ");

            $stmt_user->execute( array(
                ':user_name' => $data['user_name'],
                ':user_password' => $password,
                ':email' => $data['user_email'],
                ':user_key' =>  $login_key
            ) );

            $user_id =  $this->getFrontEngine()->getObjDataBase()->lastInserId();

        $_SESSION['user']['key'] = $login_key;

        return $user_id;
    }

    /**
     * @param $data
     * @throws \Exception
     */
    function login($data ) {

        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT
              `email`,
              `password`,
              `key` 
            FROM 
              `user`
            WHERE
              `email` = :user_email
              OR
              `user_name` = :user_email 
            ");
        $result = $stmt->execute( array( ':user_email' => $data['user_email'] ) );
        /**
         * @var dtoUser $objUser
         */
        $objUser = $result->fetchOne( dtoUser::class );

        if( !$objUser ) {
            throw  new \Exception( 'Грешно име или парола');
        } else {

            if( !password_verify( $data['user_password'] ,$objUser->getPassword() ) ) {
                throw  new \Exception( 'Грешно име или парола');
            }
        }

        $_SESSION['user']['key'] = $objUser->getKey();
    }

    function view() {
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT 
              `user_id`,
              `user_name`,
              `first_name`,
              `last_name`,
              `email`,
              `age`,
              `sex`,
              `web`,
              `avatar`,
              `avatar_ext`
            FROM
              `user`  
            WHERE
              `user_id` = $user_id
        ");

        $result = $stmt->execute();

        return $result->fetchOne(dtoUser::class );
    }

    function editView() {
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();
        $stmt = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT 
              `user_id`,
              `user_name`,
              `first_name`,
              `last_name`,
              `email`,
              `age`,
              `sex`,
              `web`,
              `avatar`,
              `avatar_ext`
            FROM
              `user`
            WHERE
              `user_id` = $user_id
        ");

        $result = $stmt->execute();

        return $result->fetchOne(dtoUser::class );
    }

    function editSave( $arrFil = [], $arrAvatar = [] ) {

        $this->getFrontEngine()->getObjDataBase()->beginTransaction();
        $user_id = $this->getFrontEngine()->getObjUser()->getUserId();

        foreach ( $arrFil['data'] as $key => $value ) {
            $stmt = $this->getFrontEngine()->getObjDataBase()->query("
              UPDATE 
                `user`
              SET 
                $key = :$key
              WHERE 
                `user_id` = $user_id
           ");
            $stmt->execute( array(':'.$key => $value));
        }

        if( $arrFil['avatar'] ) {
            $stmt_avatar = $this->getFrontEngine()->getObjDataBase()->query("
                UPDATE
                    `user`
                SET
                `avatar` = :avatar,
                `avatar_ext` = :ext
                WHERE
                 `user_id` = $user_id
            ");
            $stmt_avatar->execute( array(':avatar' => $arrAvatar['new'], ':ext' => $arrAvatar['newExt']) );
        }

        $this->getFrontEngine()->getObjDataBase()->commit();
    }

    // Check method

    /**
     * @param $name
     * @param $email
     * @throws \Exception
     */
    function isExistUser($name, $email ) {
        /**
         * @var dtoUser $objUser
         */
        $stmt = $this->getFrontEngine()->getObjDataBase()->query( "
            SELECT `user_name`,
              `email` 
            FROM 
              `user`
            WHERE
              `user_name` = :user_name
              OR
              `email` = :email
        ");

        $result = $stmt->execute( array( ':user_name' => $name, ':email' => $email ) );

        $objUser = $result->fetchOne( dtoUser::class );

        if( $objUser  ) {
            if( $objUser->getUserName() == $name ) {

                throw new \Exception('Името "'.$name.'" се използва от друг потребител!');
            } else if ( $objUser->getEmail() == $email ) {
                throw new \Exception( 'E-mail адресът "'.$email.'" се използва от друг потребител!');
            }
        }
    }

    function isChangeEmail( $objUser, $newEmail ) {
        /**
         * @var dtoUser $objUser
         */
        $user_id = $objUser->getUserId();
        $stmt_exs_email = $this->getFrontEngine()->getObjDataBase()->query("
            SELECT 
              `user_id`
            FROM
              `user`
            WHERE
              `user_id` != $user_id
              AND
              `email` = :email
        ");

        $result = $stmt_exs_email->execute( array( ':email' => $newEmail ) );

        return $result->fetchOne( dtoUser::class );
    }
}
