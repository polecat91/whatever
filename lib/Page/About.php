<?php

    class Admin_Page_About
	{
		
        public function __construct() {
            $this->contentDisplay();
		}
        
        private function adminUser() {
            $objAdminUser = new Admin_User();
            return $objAdminUser->getUserBasicInfo();
        }
        
        public function contentDisplay() {
            global $APP_CONF, $ADM;
            
            //own setup
            $tblUser = $this->adminUser();
            //own setup END
            
            //CONST setup
            $strTemplate = $APP_CONF['sys'] . str_replace('_', '/', __CLASS__) . '.php';
            require_once $strTemplate;
        }
        
	}	
?>