<?php

    session_name($APP_CONF['site_name']);
    session_start();


	class Init
	{

        private $_numUserID;
        private $_strUserFirstName;
        private $_strUserLastName;
        private $_strUserEmai;
        private $_strUserPhone;
        private $_numGroupID;
        private $_strModuleName;
        private $_strPageName;
        private $_numPageID;

        private $_rowUser;
        private $_rowGroup;


        public function __construct() {
            $this->_numUserID = NULL;
            $this->_strUserFirstName = NULL;
            $this->_strUserLastName = NULL;
            $this->_strUserEmai = NULL;
            $this->_strUserPhone = NULL;
            $this->_numGroupID = NULL;
            $this->_strModuleName = NULL;
            $this->_strPageName = NULL;
            $this->_numPageID = NULL;

            $this->_rowUser = ($_SESSION['user'] ? $_SESSION['user'] : NULL);
            $this->_rowGroup = array();

            $this->init();
		}

        /**
         * 
         * @global type $ADM
         * @global type $rowUrl
         * @global type $objDb
         */
        private function init() {
            global $APP_CONF, $rowUrl, $objDb;

            if($rowUrl[0] == 'Webservice') {
//            Amennyiben ajax hívás volt
                $strClassName = "Web_{$rowUrl[0]}_{$rowUrl[1]}";
                if(class_exists("Web_{$rowUrl[0]}_{$rowUrl[1]}")) {
                    $rowWebserviceObject[] = new $strClassName;
                }
            } else {
//            normál oldalbetöltésif(!$this->_rowUser) {
                if(!$this->_rowUser) {
                    $this->_strPageName = 'Login';
                } else if(is_file("{$APP_CONF['lib']}Page/" . trim(ucfirst($rowUrl[0])) . ".php")) {
                    $this->_strPageName = trim(ucfirst($rowUrl[0]));
                } else if(!$rowUrl[0]) {
                    $this->_strPageName = ucfirst($APP_CONF['default_page']);
                } else {
                    $this->_strPageName = '404';
                }
            }
            $this->loadPage($this->addWebservice());
        }


        /**
         * Betöltjük az oldal teljes tartalmát [head|header|content|footer]
         * @global type $APP_CONF
         * @global type $ADM
         * @global type $rowUrl
         * @param type $rowWebserviceObject
         * @author Csáki Viktor <Developer>
         */
        private function loadPage($rowWebserviceObject = NULL) {
            global $APP_CONF, $rowUrl;

            if($this->_strPageName) {
                $strPage = $this->_strPageName; //TODO global for included files
                require_once "{$APP_CONF['sys']}Content/Head.php";
                if($this->_rowUser && $this->_strPageName != '404') {
                    require_once "{$APP_CONF['sys']}Content/Header.php";
                }
                $strClass = "Page_{$this->_strPageName}";
                new $strClass();

                if($rowWebserviceObject) {
                    foreach ($rowWebserviceObject AS $objWebservice) {
                        if(method_exists($objWebservice, 'getFunction')) {
                            print $objWebservice->getFunction();
                        }
                    }
                }

                require_once "{$APP_CONF['sys']}Content/Footer.php";
            }
		}

        /**
         * v0.9
         * file név és elérés alapján betöltjük a css/js-eket
         * TODO automatizálni, hogy ne legyen egyesével beégetve a head/footer-ben
         * TODO ajax híváskor is be kell tölteni a megfelelőt, hogy ne első betöltéskor legyen bent minden. Csak ami kell
         * @global type $ADM
         * @global type $APP_CONF
         * @param type $strFileName
         * @param type $strPath
         * @author Csáki Viktor <Developer>
         */
        public static function getScript($strFileName, $strPath = NULL) {
            global $ADM, $APP_CONF;
            if($strFileName) {
                $strExtension = pathinfo($strFileName)['extension'];
                if($strPath) {
                    $strFilePath = "{$APP_CONF['path']}{$strPath}{$strFileName}";
                } else {
                    $strFilePath = ($strExtension == 'js' ? "{$ADM['js']}{$strFileName}" : "{$ADM['css']}{$strFileName}");
                }
                if(is_file($strFilePath)) {
                    $strFileTime = "?v=" . filemtime($strFilePath);
                    if($strExtension == 'css') {
                        print "
                            <link href=\"" . ($strPath ? "{$APP_CONF['base_url']}{$strPath}" : "{$APP_CONF['base_url']}assets/css/") . "{$strFileName}{$strFileTime}\" rel=\"stylesheet\">";
                    } else if($strExtension == 'js') {
                        print "
                            <script src=\"" . ($strPath ? "{$APP_CONF['base_url']}{$strPath}" : "{$APP_CONF['base_url']}assets/js/") . "{$strFileName}{$strFileTime}\"></script>";
                    }
                }
            }
        }

        final private function addWebservice() {
            $rowClassName = array(
                $this->_strPageName => "Web_Webservice_{$this->_strPageName}",
                "web" => "Web_Webservice_About"
            );

            foreach($rowClassName AS $strParam => $strClassName) {
                if(class_exists($strClassName)) {
                    $rowWebserviceObject[] = new $strClassName(ucfirst($strParam));
                }
            }

            return $rowWebserviceObject;
        }

        public function getRowAdminUser() {
            return $this->_rowUser;
        }

        public function getStrUserFirstName() {
            return $this->_rowUser['first_name'];
        }
        public function getStrUserLastName() {
            return $this->_rowUser['last_name'];
        }
        public function getStrUserEmail() {
            return $this->_rowUser['email'];
        }
        public function getStrUserPhone() {
            return $this->_rowUser['phone'];
        }
        public function getStrUserGroupID() {
            return $this->_rowUser['group_id'];
        }

	}

?>