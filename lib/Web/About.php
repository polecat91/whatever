<?php


	class Web_About
	{

        private $_numTaskID;

        public function __construct($numTaskID = NULL) {
            $this->_numTaskID = $numTaskID;
        }
        
        public function getTask() {
            global $objDb;
            
            $strGetTask = "
                SELECT
                     id
                    ,title
                    ,description
                    ,is_success
                    ,create_date
                FROM
                    task
                WHERE
                    user_id = {$_SESSION['user']['user_id']}
                    AND status IS TRUE
            ";
            if($this->_numTaskID) {
                $strGetTask .= "
                    AND id = {$this->_numTaskID}
                ";
                $tblTask = $objDb->getRow($strGetTask);
            } else {
                $strGetTask .= "
                    ORDER BY
                         is_success ASC
                        ,id DESC
                ";
                $tblTask = $objDb->getAll($strGetTask);
            }
            if(!DB::isError($tblTask)) {
                return $tblTask;
            }

            return FALSE;
        }
        
        /**
         * Add new task row
         * @global type $objDb
         * @param type $rowTask
         * @return type
         */
        public function AddTask($rowTask) {
            global $objDb;
            
            if($rowTask['title'] && $rowTask['desc'] && is_numeric($rowTask['success'])) {
                $strAddTask = "
                    INSERT INTO
                        task
                    SET
                         user_id = {$_SESSION['user']['user_id']}
                        ,title = '{$rowTask['title']}'
                        ,description = '{$rowTask['desc']}'
                        ,is_success = '{$rowTask['success']}'
                        ,create_user = '{$_SESSION['user']['username']}'
                ";
                $objAddTask = $objDb->query($strAddTask);
                if(!DB::isError($objAddTask)) {
                    $numLadtID = $objDb->getOne('SELECT LAST_INSERT_ID()');
                    return array("isError" => FALSE, "message" => 'Feladat mentése sikerült.', 'numLastID' => $numLadtID);
                }
            }
            return array("isError" => TRUE, "message" => 'Feladat mentése sikertelen.');
        }

        /**
         * TODO Nem kerül a sor végleges törlésre, csak a status változik meg. FALSE statuszú sorok az listán nem jelennek meg!
         * @global type $objDb
         * @param type $rowTask
         */
        public function RemoveTask($rowTask) {
            global $objDb;
            if($rowTask['id']) {
                $strRemoveTask = "
                    UPDATE
                        task
                    SET
                         status = 0
                        ,modify_user = '{$_SESSION['user']['username']}'
                        ,modify_date = NOW()
                    WHERE
                        id = {$rowTask['id']}
                        AND user_id = {$_SESSION['user']['user_id']}
                ";
                $objRemoveTask = $objDb->query($strRemoveTask);
                if(!DB::isError($objRemoveTask)) {
                    return array("isError" => FALSE, "message" => 'Feladat törlése sikerült.');
                }
            }
            return array("isError" => FALSE, "message" => 'Feladat törlése sikertelen.');
        }

        /**
         * Modify task
         * @global type $objDb
         * @return type
         */
        public function ModifyTask($rowTask) {
            global $objDb;
            if($rowTask['title'] && $rowTask['desc'] && is_numeric($rowTask['success']) && is_numeric($rowTask['id'])) {
                $strRemoveTask = "
                    UPDATE
                        task
                    SET
                         title = '{$rowTask['title']}'
                        ,description = '{$rowTask['desc']}'
                        ,is_success = '{$rowTask['success']}'
                        ,modify_user = '{$_SESSION['user']['username']}'
                        ,modify_date = NOW()
                    WHERE
                        id = {$rowTask['id']}
                        AND user_id = {$_SESSION['user']['user_id']}
                ";
                $objRemoveTask = $objDb->query($strRemoveTask);
                if(!DB::isError($objRemoveTask)) {
                    return array("isError" => FALSE, "message" => 'Feladat módosítása sikerült.');
                }
            }
            return array("isError" => TRUE, "message" => 'Feladat módosítása sikertelen.');
        }
        
	}	
?>