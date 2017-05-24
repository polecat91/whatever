<?php

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
    
?>