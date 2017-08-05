<?php
$Module = array( "name" => "Admin",
                 "variable_params" => true,
                 "function" => array(
                     "script" => "changeuser.php",
                     "params" => array( ) ) );

$ViewList = array();
$ViewList["changeuser"] = array(
    "script" => "changeuser.php",
    'params' => array( 'ObjectID' ) );
$ViewList["backup"] = array(
    "script" => "backup.php",
    'params' => array(  ) );
$ViewList["phpinfo"] = array(
    "script" => "phpinfo.php",
    'params' => array(  ) );
$ViewList["menu"] = array(
    "script" => "menu.php",
    'params' => array(  ) );
$ViewList["sqlquery"] = array(
    "script" => "sqlquery.php",
    'params' => array( 'sql' ) );

$FunctionList['userchange'] = array( );
$FunctionList['backup'] = array( );
$FunctionList['phpinfo'] = array( );
$FunctionList['menu'] = array( );
$FunctionList['sqlquery'] = array( );
?>
