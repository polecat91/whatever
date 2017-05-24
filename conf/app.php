<?php

include_once 'env.php';

$APP_CONF = array();

$APP_CONF['version'] = $ENV['base']['version'];

$APP_CONF['site_name'] = $ENV['base']['site_name'];

$APP_CONF['base_url'] = "{$ENV['base']['base_local']}{$APP_CONF['site_name']}/";

$APP_CONF['path'] = "{$ENV['base']['base_path']}{$APP_CONF['site_name']}/";
$APP_CONF['lib'] = "{$APP_CONF['path']}lib/";
$APP_CONF['sys'] = "{$APP_CONF['path']}sys/";

$APP_CONF['log'] = "{$APP_CONF['sys']}log/";

$APP_CONF['assets'] = "{$APP_CONF['path']}assets/";
$APP_CONF['common'] = "{$APP_CONF['lib']}Common/";

$strDefaultLang = "HU";

include_once "{$APP_CONF['common']}Component.php";

ini_set("include_path", $APP_CONF['path']);
define("PEAR", $APP_CONF['common']);
spl_autoload_register('myAutoloader');

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED |E_STRICT));

//set rowUrl
$strUrl = NULL;
$rowUrl = array();
if($_REQUEST) {
    $strUrl = $_REQUEST['s'];
    $rowUrl = array_values(array_filter(explode('/', $strUrl)));
}


include_once 'db.php';
//$objMenu = new Web_Menu();
$objInit = new Init();

?>