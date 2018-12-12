<?php
    namespace Controllers;
    use DTO\dtoUser;
    use Interfaces\pageController;
    use Models\userModels;

    class userController extends pageController{

        const userName_maxLen = 16;
        const userName_minLen = 3;
        const userFirstName_maxLen = 16;
        const userFirstName_minLen = 3;
        const userLastName_maxLen = 16;
        const userLastName_minLen = 3;
        const userPassword_maxLen = 16;
        const userPassword_minLen = 4;
        const userAge_maxValue = 100;
        const userAge_minValue = 0;
        const userWeb_maxLen = 255;

        const avatarNameLen = 20;
        const avatarMaxSize = 300;
        const avatarDirectory = 'public/avatars/';

        public function register() {

            $objModel = new userModels( $this->getFrontEngine() );

            $_POST = array_map( 'my_striptags', $_POST );
            $_POST = array_map( 'my_htmlspecialchars', $_POST );
            $_POST = array_map( 'my_trim', $_POST );

            $post['user_name'] = $_POST['user_name']??NULL;
            $post['user_password'] = $_POST['user_password']??NULL;
            $post['user_password_re'] = $_POST['user_password_re']??NULL;
            $post['user_email'] = $_POST['user_email']??NULL;
            $post['user_email_re'] = $_POST['user_email_re']??NULL;

            try {
                if( isset( $_POST['type'] ) && $_POST['type'] == "register" ) {

                    $objModel->isExistUser( $post['user_name'], $post['user_email'] );

                    if( mb_strlen( $post['user_name'] ) < self::userName_minLen || mb_strlen( $post['user_name'] ) > self::userName_maxLen ) {
                        throw new \Exception("Името трябва да садържа ". self::userName_minLen ." минимум и максимум ". self::userName_maxLen ." символа!");
                    }

                    if( mb_strlen( $post['user_password'] ) < self::userPassword_minLen || mb_strlen( $post['user_password'] ) > self::userPassword_maxLen ) {
                        throw new \Exception('Паролата трябва да садържа минимум '. self::userPassword_minLen .' и максимум '. self::userPassword_maxLen .' символа!');
                    }

                    if( $post['user_password'] != $post['user_password_re']) {
                        throw new \Exception( 'Паролите не съвпадат!');
                    }

                    if( !filter_var( $post['user_email'], FILTER_VALIDATE_EMAIL ) ) {
                        throw new \Exception( 'Невалиден e-mail!');
                    }

                    if( $post['user_email'] != $post['user_email_re'] ) {
                        throw new \Exception('E-mail адресът не съвпада.');
                    }

                    $newUser = $objModel->register( $post );
                    $this->getViewEngine()->successMessage('Добре дошли в Пчелна градина.');
                    $this->getViewEngine()->redirect( "/user/view/".$newUser );
                }

            } catch ( \Exception $e) {
                $this->getFrontEngine()->setErrorEngine( $e );
            }


            $this->getViewEngine()->layout( array(), $post );
        }

        public function login() {
            $objModel = new userModels( $this->getFrontEngine() );
            $post = [];

            try {

                if( isset( $_POST['type'] ) && $_POST['type'] == "login" ) {

                    $_POST = array_map( 'my_striptags', $_POST );
                    $_POST = array_map( 'my_htmlspecialchars', $_POST );
                    $_POST = array_map( 'my_trim', $_POST );

                    $objModel->login( array('user_email' => $_POST['user_email'], 'user_password' => $_POST['user_password'] ) );

                    $this->getViewEngine()->successMessage('Добре дошли отново!');

                    $this->getViewEngine()->redirect( "/home" );

                }

            } catch ( \Exception $e ) {

                $this->getFrontEngine()->setErrorEngine( $e );
            }

            $this->getViewEngine()->layout( array(), $post );
        }

        public function logout() {
            session_destroy();
            $this->getViewEngine()->redirect( "/home" );
        }

        public function lostpassword() {

        }

        public function view() {
            /** @var userModels $modelUser */
            $modelUser = new userModels( $this->getFrontEngine() );

            $arrMenu = array(
                array('url' => 'user/edit'),
                array('url' => 'list/list')
            );
            $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( $arrMenu );
            $arrData['objUser'] = $modelUser->view();
            $arrPage = array(
                'Layout/leftMenu',
                'view'
            );

            $this->getViewEngine()->layout( $arrPage, $arrData  );
        }

        public function edit() {

            /** @var userModels $modelUser */
            $modelUser = new userModels( $this->getFrontEngine() );

            /** @var dtoUser $objUser */
            $objUser = $modelUser->editView();

            try {

                if(count($_POST)) {

                    $_POST = array_map( 'my_striptags', $_POST );
                    $_POST = array_map( 'my_htmlspecialchars', $_POST );
                    $_POST = array_map( 'my_trim', $_POST );
                    $_POST['age'] = intval( $_POST['age'] );

                    $arrFil = array();
                    $arrAvatar = array();

                    if( mb_strlen( $_POST['firstName'] ) >= 1 ) {
                        if (mb_strlen($_POST['firstName']) < self::userFirstName_minLen || mb_strlen($_POST['firstName']) > self::userFirstName_maxLen) {
                            throw new \Exception("Името трябва да садържа минимум " . self::userFirstName_minLen . " и максимум " . self::userFirstName_maxLen . " символа!");
                        }
                        $arrFil['data']['first_name'] = $_POST['firstName'];
                    }

                    if( mb_strlen( $_POST['lastName'] ) >= 1 ) {
                        if (mb_strlen($_POST['lastName']) < self::userLastName_minLen || mb_strlen($_POST['lastName']) > self::userLastName_maxLen) {
                            throw new \Exception("Фамилията трябва да садържа минимум " . self::userLastName_minLen . " и максимум " . self::userLastName_maxLen . " символа!");
                        }
                        $arrFil['data']['last_name'] = $_POST['lastName'];
                    }

                    if( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
                        throw new \Exception( 'Невалиден e-mail!');
                    }
                    if( $modelUser->isChangeEmail( $objUser, $_POST['email'] ) ) {
                        throw new \Exception( 'Имей адресът "'. $_POST['email'] .'" се използва от друг потребител !');
                    }
                    $arrFil['data']['email'] = $_POST['email'];

                    if ( $_POST['age'] < self::userAge_minValue || $_POST['age']  > self::userAge_maxValue ) {
                        throw new \Exception("Годините не може да са под " . self::userAge_minValue . " и над " . self::userAge_maxValue . " !");
                    }
                    $arrFil['data']['age'] = $_POST['age'];

                    if( isset( $_POST['sex'] ) ) {
                        if ($_POST['sex'] != '0' && $_POST['sex'] != '1') {
                            throw new \Exception('Невалиден пол');
                        }
                        $arrFil['data']['sex'] = $_POST['sex'];
                    }

                    if( mb_strlen( $_POST['web'] ) >= 1 ) {
                        if (mb_strlen($_POST['web']) > self::userWeb_maxLen) {
                            throw new \Exception("Уеб Сайт трябва да садържа максимум " . self::userWeb_maxLen . " символа!");
                        }
                        $arrFil['data']['web'] = $_POST['web'];
                    }

                    if( mb_strlen( $_POST['new_password'] ) >= 1 ) {

                        $arrFil['new_password'] = true;
                        if( $_POST['new_password'] != $_POST['renew_password'] ) {
                            throw new \Exception( 'Новата парола не съвпада!');
                        }

                        if( mb_strlen( $_POST['new_password'] ) < self::userPassword_minLen || mb_strlen( $_POST['new_password'] ) > self::userPassword_maxLen ) {
                            throw new \Exception('Новата парола трябва да садържа минимум '. self::userPassword_minLen .' и максимум '. self::userPassword_maxLen .' символа!');
                        }

                        if( !password_verify( $_POST['password'], $this->getFrontEngine()->getObjUser()->getPassword() ) ) {

                            throw new \Exception( 'Грешна парола');
                        }
                        $arrFil['data']['password'] = password_hash( $_POST['new_password'], PASSWORD_DEFAULT );

                    }

                    if ( isset( $_FILES['avatarFile']['tmp_name'] ) && $_FILES['avatarFile']['tmp_name'] ) {

                        $exFile = $_FILES['avatarFile']['tmp_name'];
                        $arrImg = getimagesize($exFile);

                        if( $arrImg['mime'] != "image/jpeg" && $arrImg['mime'] != "image/png" && $arrImg['mime'] != "image/gif") {
                            throw new \Exception('Поддържани разширения за аватар jpeg, png и gif.');
                        }

                        $exWidth = $arrImg[0];
                        $exHeight = $arrImg[1];
                        $exMimeType = $arrImg['mime'];

                        switch ($exMimeType) {
                            case 'image/jpeg':
                                $image_create_func = 'imagecreatefromjpeg';
                                $image_save_func = 'imagejpeg';
                                $quality = 100;
                                $ext = 'jpeg';
                                break;

                            case 'image/png':
                                $image_create_func = 'imagecreatefrompng';
                                $image_save_func = 'imagepng';
                                $quality = 9;
                                $ext = 'png';
                                break;

                            case 'image/gif':
                                $image_create_func = 'imagecreatefromgif';
                                $image_save_func = 'imagegif';
                                $quality = 0;
                                $ext = 'gif';
                                break;

                            default:
                                throw new \Exception('Unknown image type.');
                        }

                        $aspectRatio = max($exWidth, $exHeight) / self::avatarMaxSize;
                        $newWidth = $exWidth / $aspectRatio;
                        $newHeight = $exHeight / $aspectRatio;

                        $newGDimage = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresampled($newGDimage, $image_create_func($exFile), 0, 0, 0, 0, $newWidth, $newHeight, $exWidth, $exHeight);
                        imagealphablending($newGDimage, true);
                        imageSaveAlpha($newGDimage, true);

                        while ($name = my_randstr(self::avatarNameLen )) {
                            $file_Patch = self::avatarDirectory . $name ."." . $ext;
                            $filePatchThumb = self::avatarDirectory . $name ."_thumbnail.". $ext;
                            if (!file_exists($file_Patch)) {
                                break;
                            }
                        }

                        $arrAvatar['current'] = $objUser->getAvatar();
                        $arrAvatar['currentExt'] = $objUser->getAvatarExt();

                        $arrAvatar['new'] = $name;
                        $arrAvatar['newExt'] = $ext;

                        if( mb_strlen( $objUser->getAvatar() ) ) {

                            $currentPatch = self::avatarDirectory . $arrAvatar['current'] .".". $arrAvatar['currentExt'];
                            if( file_exists( $currentPatch )) {
                                unlink( $currentPatch );
                            }

                            $currentPatchThumb = self::avatarDirectory . $arrAvatar['current'].'_thumbnail.'. $arrAvatar['currentExt'];
                            if( file_exists($currentPatchThumb )) {
                                unlink( $currentPatchThumb );
                            }
                        }

                        move_uploaded_file( $_FILES['avatarFile']['tmp_name'], $file_Patch);
                        $image_save_func($newGDimage, $filePatchThumb, $quality );

                        $arrFil['avatar'] = true;
                    } else{
                        $arrFil['avatar'] = false;
                    }

                    $modelUser->editSave( $arrFil, $arrAvatar );

                    $this->getViewEngine()->successMessage( 'Профилът е променен!.' );
                    $this->getViewEngine()->redirect( "/user/edit");
                }

            } catch( \Exception $e ) {
                $this->getFrontEngine()->setErrorEngine( $e );
            }

            $arrData['leftMenu'] = $this->getViewEngine()->pageLeftMenu( array(
                array('url' => 'user/edit'),
                array('url' => 'list/list')
            ) );
            $arrData['objUser'] = $objUser;
            $arrPage = array(
                'Layout/leftMenu',
                'edit'
            );
            $this->getViewEngine()->layout( $arrPage, $arrData );
        }

        public function guest() {
            $this->getViewEngine()->layout();
        }

        public function disease() {

        }

    }