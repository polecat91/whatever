<?php

    class Admin_Menu
    {

        private $_tblMenu;
        private $_numMenuID;

        public function __construct($numID) {
            $this->_tblMenu = NULL;
            $this->_numMenuID = $numID;
            if(!$numID) {
                $this->setMenu();
            }
        }

        private function setMenu() {
            global $objDb;

            $tblModule = $this->setModules();
            $tblFunction = $this->setFunction();

            foreach($tblFunction AS $numID => $rowFunction) {
                $rowModule = $tblModule[$rowFunction['module_id']];
                if($rowModule) {
                    if(!$this->_tblMenu[$rowModule['id']]) {
                        $this->_tblMenu[$rowModule['id']] = $rowModule;
                    }
                    $this->_tblMenu[$rowModule['id']]['chield'][$numID] = $rowFunction;
                }
            }
        }

        private function setModules() {
            global $objDb;

            $tblGetModule = $objDb->getAll("
                SELECT
                     id
                    ,name
                    ,url
                    ,glyphicon
                FROM
                    sys_module
                WHERE
                    status IS TRUE
            ");

            if(!DB::isError($tblGetModule) && $tblGetModule) {
                foreach($tblGetModule AS $rowModule) {
                    $tblModule[$rowModule['id']] = $rowModule;
                }
                return $tblModule;
            }

            return FALSE;
        }

        private function setFunction() {
            global $objDb;

//            TODO module page
            $strGetFunction = "
                SELECT
                     f.id
                    ,f.name
                    ,f.module_id
                    ,f.url
                FROM
                    sys_function AS f
                LEFT JOIN
                    sys_permission AS p ON (p.page_id = f.id)
                WHERE
                    f.status IS TRUE
                    AND p.page_type = 4
            ";
            if( $_SESSION['admin_user']['group_id'] > 1 ) {
                $strGetFunction .= "
                    AND p.group_id = {$_SESSION['admin_user']['group_id']}
                ";
            }
            $tblGetFunction = $objDb->getAll($strGetFunction);

            if(!DB::isError($tblGetFunction) && $tblGetFunction) {
                foreach($tblGetFunction AS $rowFunction) {
                    $tblFunction[$rowFunction['id']] = $rowFunction;
                }
                return $tblFunction;
            }

            return FALSE;
        }

        public static function getFunctionData($strModule, $strFunction) {
            global $objDb;

            if($strModule && $strFunction) {
                $rowStatus = $objDb->getRow("
                    SELECT
                         f.id
                        ,f.status
                        ,f.visible
                        ,f.name
                    FROM
                        sys_function AS f
                    JOIN
                        sys_module AS m ON(m.id = f.module_id)
                    WHERE
                        f.url = '{$strFunction}'
                        AND m.url = '{$strModule}'
                ");
                if(!DB::isError($rowStatus)) {
                    return $rowStatus;
                }
            }

            return FALSE;
        }

        public static function getPageByURL($rowUrl) {
            global $ADM, $objDb;

            $strPage = ($rowUrl[0] ? $rowUrl[0] : $ADM['default_page']);

            if($_SESSION['admin_user']['group_id'] !== NULL) {
                $strGetPage = "
                    SELECT
                        pages.*
                    FROM
                        sys_permission AS p
                    LEFT JOIN
                        (
                            (
                                SELECT DISTINCT
                                     f.id
                                    ,f.status
                                    ,f.visible
                                    ,'fn' AS `type`
                                    ,f.module_id
                                    ,f.name
                                    ,f.url
                                    ,NULL AS parent_page_id
                                    ,f.create_date AS function_create_date
                                    ,f.create_user AS function_create_user
                                    ,f.modify_date AS function_modify_date
                                    ,f.modify_user AS function_modify_user
                                    ,m.status AS module_status
                                    ,m.name AS module_name
                                    ,m.url AS module_url
                                    ,m.create_date AS module_create_date
                                    ,m.create_user AS module_create_user
                                    ,m.modify_date AS module_modify_date
                                    ,m.modify_user AS module_modify_user
                                FROM
                                    sys_function AS f
                                JOIN
                                    sys_module AS m ON (m.id = f.module_id)
                                ORDER BY m.priority
                            )
                            UNION ALL
                            (
                                SELECT DISTINCT
                                     p.id
                                    ,p.status
                                    ,NULL
                                    ,'p' AS `type`
                                    ,NULL
                                    ,p.name
                                    ,p.url
                                    ,p.parent_page_id
                                    ,p.create_date AS page_create_date
                                    ,p.create_user AS page_create_user
                                    ,p.modify_date AS page_modify_date
                                    ,p.modify_user AS page_modify_user
                                    ,NULL
                                    ,NULL
                                    ,NULL
                                    ,NULL
                                    ,NULL
                                    ,NULL
                                    ,NULL
                                FROM
                                    sys_page AS p
                                GROUP BY
                                    p.name
                            )
                        ) AS pages ON (pages.id = p.page_id)
                    JOIN
                        sys_group AS g ON (p.group_id = g.id)
                    WHERE
                        pages.status IS TRUE
                ";
                if( $_SESSION['admin_user']['group_id'] > 1 ) {
                    $strGetPage .= "
                        AND g.id = {$_SESSION['admin_user']['group_id']}
                    ";
                }
                if(!$rowUrl[1]) {
                    $strGetPage .= "
                        AND pages.url = '{$strPage}'
                    ";
                } else if($rowUrl[1]) {
                    $strGetPage .= "
                        AND pages.url = '{$rowUrl[1]}'
                        AND pages.module_url = '{$rowUrl[0]}'
                    ";
                }

                $rowPage = $objDb->getRow($strGetPage);
                if(!DB::isError($rowPage) && $rowPage) {
                    return $rowPage;
                }

                return array('name' => '404');
            }

            return array('name' => 'Login');
        }

        public function getTtblMenu() {
            return $this->_tblMenu;
        }

    }


?>