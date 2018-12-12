<?php
    namespace Engines;

    use Database\PDODatabase;
    use DTO\dtoUser;

    class frontEngine {

        /** @var string */
        private $dirControllers = "Controllers";

        /** @var string */
        private $dirModels = "Models";

        /** @var string */
        private $dirLayout = "Layout";

        /** @var string */
        private $dirInclude = "Include";

        /** @var string */
        private $defController = "user";

        /** @var string */
        private $defAction = "guest";

        /** @var string */
        private $defParameter = "";

        /** @var string */
        private $controller;

        /** @var string */
        private $action;

        /** @var string */
        private $parameter;

        /** @var PDODatabase */
        private $objDataBase;

        /** @var dtoUser */
        private $objUser;

        /** @var \Exception */
        private $errorEngine;

        /** @var array|bool */
        private $config;
        /**` @var array|bool */

        function __construct()
        {
            $this->config = parse_ini_file( $this->dirInclude .'/config.ini', true );

            $arrFunction = scandir( $this->dirInclude. "/functions" );
            array_shift( $arrFunction );
            array_shift( $arrFunction );
            foreach ( $arrFunction as $value ) {
                require_once $this->dirInclude."/functions/". $value;
            }
            $_POST = array_map( "my_striptags", $_POST );
            $_GET = array_map( "my_striptags", $_GET );

            $dataBase = new \PDO( "{$this->config['database']['type']}:dbname={$this->config['database']['dbname']};host={$this->config['database']['host']};charset={$this->config['database']['charset']}", $this->config['database']['user'], $this->config['database']['password'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION] );

            $this->objDataBase = new PDODatabase( $dataBase );
            $userEngine = new userEngine( $this->objDataBase );
            $this->setObjUser( $userEngine->isLogin() );

            $arr = explode( "/",  $_SERVER['REDIRECT_URL']?? '' );

            $arrURL = [];
            for ( $i = 0; $i < count( $arr ); $i++ ) {
                if( strlen( $arr[$i] ) ) {
                    $arrURL[] = $arr[$i];
                }
            }
            unset( $arr );

            $this->setController($arrURL[0]??null );
            $this->setAction($arrURL[1]??null );
            $this->setParameter( $arrURL[2]??null );

            if( !$this->objUser && !( $this->getController() == 'user' && ( $this->getAction() == 'login' || $this->getAction() == 'register' ) ) ) {
               $this->setController('user' );
               $this->setAction( 'guest' );
            }

            if( file_exists( $this->dirControllers.'\\'. $this->getController() ."Controller".'.php' ) ) {
                $controller = $this->dirControllers.'\\'. $this->getController() ."Controller";
            } else {
                $controller = $this->dirControllers.'\\'. $this->defController ."Controller";
            }

            $objController = new $controller( $this );

            if( !method_exists( $objController, $this->getAction() ) ) {
                $controller = $this->dirControllers.'\\'. $this->defController ."Controller";

                $objController = new $controller( $this );
                $this->setAction( $this->defAction );
            }

            $objController->{ $this->getAction() }();

        }

        /** @return string */
        private function getDirControllers(): string
        {
            return $this->dirControllers;
        }

        /** @param string $dirControllers */
        private function setDirControllers(string $dirControllers): void
        {
            $this->dirControllers = $dirControllers;
        }

        /** @return string */
        private function getDirModels(): string
        {
            return $this->dirModels;
        }

        /** @param string $dirModels */
        private function setDirModels(string $dirModels): void
        {
            $this->dirModels = $dirModels;
        }

        /** @return string */
        public function getDirLayout(): string
        {
            return $this->dirLayout;
        }

        /** @param string $dirLayout */
        private function setDirLayout(string $dirLayout): void
        {
            $this->dirLayout = $dirLayout;
        }

        /** @return string */
        private function getDirInclude(): string
        {
            return $this->dirInclude;
        }

        /** @param string $dirInclude */
        private function setDirInclude(string $dirInclude): void
        {
            $this->dirInclude = $dirInclude;
        }

        /** @return string */
        private function getDefController(): string
        {
            return $this->defController;
        }

        /** @param string $defController */
        private function setDefController(string $defController): void
        {
            $this->defController = $defController;
        }

        /** @return string */
        private function getDefAction() : ?string
        {
            return $this->defAction;
        }

        /** @param string $defAction */
        private function setDefAction( string $defAction ): void
        {
            $this->defAction = $defAction;
        }

        /** @return string */
        private function getDefParameter(): string
        {
            return $this->defParameter;
        }

        /** @param string $defParameter */
        private function setDefParameter(string $defParameter): void
        {
            $this->defParameter = $defParameter;
        }

        /** @return string */
        public function getController(): ?string
        {
            return $this->controller;
        }

        /** @param string $controller */
        public function setController(?string $controller): void
        {
            $this->controller = $controller;
        }

        /** @return string */
        public function getAction(): ?string
        {
            return $this->action;
        }

        /** @param string $action */
        public function setAction(?string $action): void
        {
            $this->action = $action;
        }

        /** @return string */
        public function getParameter(): ?string
        {
            return $this->parameter;
        }

        /** @param string $parameter */
        public function setParameter(?string $parameter): void
        {
            $this->parameter = $parameter;
        }

        /** @return PDODatabase */
        public function getObjDataBase(): PDODatabase
        {
            return $this->objDataBase;
        }

        /** @param PDODatabase $objDataBase */
        private function setObjDataBase(PDODatabase $objDataBase): void
        {
            $this->objDataBase = $objDataBase;
        }

        /** @return dtoUser */
        public function getObjUser(): ?dtoUser
        {
            return $this->objUser;
        }

        /** @param dtoUser $objUser */
        private function setObjUser( ?dtoUser $objUser): void
        {
            $this->objUser = $objUser;
        }

        /**
         * @return \Exception
         */
        public function getErrorEngine(): ?\Exception
        {
            return $this->errorEngine;
        }

        /**
         * @param \Exception $errorEngine
         */
        public function setErrorEngine(\Exception $errorEngine) : void
        {
            $this->errorEngine = $errorEngine;
        }

        /** @return array|bool */
        public function getConfig()
        {
            return $this->config;
        }

        /** @param array|bool $config */
        private function setConfig($config): void
        {
            $this->config = $config;
        }

    }