<?php
include_once( "lib/ezutils/classes/ezhttptool.php" );
include_once( "kernel/common/template.php" );
include_once( 'kernel/classes/ezcontentobject.php' );

#module ref
$module =& $Params["Module"];

#sessions
$http =& eZHTTPTool::instance();

#template
$tpl =& templateInit();

// Build module result array
$Result = array();
$Result['path'] = array( array( 'url' => 'mymodule',
                                'text' => "mymodule"),array( 'url' => 'hello',
                                'text' => "hello") );
                                
if ( $module->isCurrentAction( "Generate" ) )
{
    if ($module->hasActionParameter( "Year" ) && $module->hasActionParameter( "Month" ) ){
   
    $tpl->setVariable( 'year', $module->actionParameter( "Year" ) );
    $tpl->setVariable( 'month', $module->actionParameter( "Month" ) );
    $tpl->setVariable( 'attributes', $module->attributes());
    eZDebug::writeDebug( "Hello error" );
    
    
    #var_dump($module->attributes());
    
    }
    $Result['content'] =& $tpl->fetch( 'design:mymodule/hello.tpl' );
}else{

#do some error or redirect

}
?>