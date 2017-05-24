<?php

//    types

    
    /**
     * Állandó értékek beállítása
     * @author Csáki Viktor <Developer>
     */
    class TYPE
    {
        const page_json_type = array(
             'table'
            ,'list'
        );
        const table_json_conf = array(
             'table_types'
            ,'table_display'
        );
        const row_registered_tag = array(
             '<b>'
            ,'</b>'
            ,'<i>'
            ,'</i>'
            ,'<u>'
            ,'</u>'
            ,'<u>'
            ,'</u>'
            ,'<small>'
            ,'</small>'
            ,'<h1>'
            ,'</h1>'
            ,'<h2>'
            ,'</h2>'
            ,'<h3>'
            ,'</h3>'
            ,'<h4>'
            ,'</h4>'
            ,'<h5>'
            ,'</h5>'
            ,'<h6>'
            ,'</h6>'
            ,'<blockquote'
            ,'</blockquote>'
            ,'<ul>'
            ,'</ul>'
            ,'<ol>'
            ,'</ol>'
            ,'<li>'
            ,'</li>'
            ,'<br>'
            ,'<a'
            ,'</a>'
            ,'<img'
            ,'>'
        );
        const row_registered_save = array(
             '[b]'
            ,'[/b]'
            ,'[i]'
            ,'[/i]'
            ,'[u]'
            ,'[/u]'
            ,'[u]'
            ,'[/u]'
            ,'[small]'
            ,'[/small]'
            ,'[h1]'
            ,'[/h1]'
            ,'[h2]'
            ,'[/h2]'
            ,'[h3]'
            ,'[/h3]'
            ,'[h4]'
            ,'[/h4]'
            ,'[h5]'
            ,'[/h5]'
            ,'[h6]'
            ,'[/h6]'
            ,'[blockquote'
            ,'[/blockquote]'
            ,'[ul]'
            ,'[/ul]'
            ,'[ol]'
            ,'[/ol]'
            ,'[li]'
            ,'[/li]'
            ,'[br]'
            ,'{[[a'
            ,'[/a]'
            ,'{[[img'
            ,']]}'
        );
    }
    
    /**
     * display típusok
     */
    class OPT_TYPE
    {
        const display = array(
             'displayPrint'
            ,'display'
            ,'displayFix'
        );
    }

//    types END

    //functions
    
    /**
     * Autoloader
     * @global type $APP_CONF
     * @param type $strClassName
     */
    function myAutoloader($strClassName) {
        global $APP_CONF;

        $strFileName = 'lib/' . str_replace("_", "/", $strClassName) . '.php';

        include_once $strFileName;
    }

    /**
     * Create underscore string to camelCase
     * @param type $input
     * @param type $separator
     * @return type
     * @author Csáki Viktor
     */
    function camelize($input, $separator = '_') {
        return str_replace($separator, '', ucwords($input, $separator));
    }
    
    function dbNull($str) {
        return ($str == NULL ? "'NULL'" : "'{$str}'");
    }
    
    function is_multi($tbl) {
        $obj = array_filter($tbl,'is_array');
        if(count($obj)>0) return true;
        return false;
    }
    
    /**
     * fast check JSON
     * @param type $string
     * @return type
     */
    function isJson($strString) {
        json_decode($strString);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    //functions END

//    Classes

    class Pre
    {
        public static function data($tbl, $isDebug = FALSE) {
            if($tbl) {
                print '<pre>';
                if($isDebug) {
                    var_dump($tbl);
                } else {
                    print_r($tbl);
                }
                print '</pre>';
            }
        }
    }
    
    class Manage
    {
        /**
         * Create AND(OR) modify log json by parent Class dir name [date].json file
         * Every day create a new json file
         * Log type is json
         * @param type $strMsg
         * @param type $strType: [NULL || 0 == error], [1 == notice]
         * @author Csáki Viktor
         */
        public static function Log($strMsg, $strType = NULL) {
            global $APP_CONF;
            
            if(!$strMsg) {
                return false;
            }
            
            $strLogDir = $APP_CONF['log'] . debug_backtrace()[1]['class'] . "/";
            $strFileName =  date("ymd") . ".json";
            $tblLog = array();
            $strDate = date("Y-m-d H:i:s");
            
            if(is_file($strLogDir.$strFileName)) {
                $strLogJson = file_get_contents($strLogDir.$strFileName);
                $tblLog = json_decode($strLogJson, true);
            }
            
            $tblLog[] = array(
                 "date" => $strDate
                ,"type" => $strType
                ,"message" => $strMsg
            );
            $strLog = json_encode($tblLog);
            
            if (!is_dir($strLogDir)) {
                mkdir($strLogDir, 0664);
            }
            file_put_contents($strLogDir.$strFileName, $strLog);
            
        }
        
        public static function flush($numPercent = 0) {
//            sleep(1);
//            print json_encode(array('flush' => $numPercent));
//            ob_flush();
//            flush();
        }
    }
//    Classes END
    
?>