<?php


	class Web_User
	{

		private $_numUserID;
		private $_strUserName;
		private $_strUserEmai;
        private $_strPageName;

        public function __construct($numUserID = NULL) {
            $this->_numUserID = $numUserID;
            $this->_strUserName = NULL;
            $this->_strUserEmai = NULL;
            $this->_strPageName = NULL;

		}


		private function set($rowUser) {
            $this->_numUserID = $rowUser['id'];
            $this->_strUserName = $rowUser['username'];
            $this->_strUserEmail = $rowUser['email'];
		}


        public function login($strEmail, $strPassword) {
            global $objDb;
            
            if(!$strEmail || !$strPassword) {
                return false;
            }

            $rowUser = $objDb->getRow("
                SELECT
                     id AS user_id
                    ,status AS user_status
                    ,username
                    ,email
                FROM
                    user
                WHERE
                    email = '{$strEmail}'
                    AND password = '{$this->setPasswd($strPassword)}'
                    AND status IS TRUE
            ");

            if(!DB::isError($rowUser) && $rowUser) {
//                accept to login
                $this->set($rowUser);
                $_SESSION['user'] = $rowUser;
                
                return TRUE;
            }
//            failed login -- invalid email and/or password
            return FALSE;

		}

		public function logout() {
            if(session_destroy()) {
                return TRUE;
            }

            return FALSE;
		}


        /**
         * Legeneraljuk az md5-olt jelszot
         * @param type $strDefaultPassword
         * @return type
         */
        private function setPasswd($strDefaultPassword) {
            return md5("p4C41P0Rk01tB4r4cK1EkV4Rr41{$strDefaultPassword}");
        }

	}	
?>