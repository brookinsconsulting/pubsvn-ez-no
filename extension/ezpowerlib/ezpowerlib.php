<?php
/**
  * Extension eZPowerLib
  * Intgration of the various libraries into eZ publish
  *
  * - PEAR ( http://pear.php.net or http://pear.php.net/go-pear )
  * - JPGRAPH ( http://www.aditus.nu/jpgraph/ )
  * - phpWhois ( http://www.phpwhois.com/ )
  *
  * Combine the tools of many worlds. Try to avoid the weakness from either one of them. Build a good and strong software. 
  * 
  *
  * Future Outlook:
  * Brings an up to date Repository
  * Will be autoinstallable
  * 
  * Bugs:
  * PEAR: All Packages that use Globals do not work.
  * JPGRAPH: 2 extensions won't include
  * 
  * Author: Björn Dieding, xrow GbR Hannover
  *
  * Sample Usage with the Pear:
  * include_once("extension/ezpowerlib/ezpowerlib.php");
  * 
  * //include now any lib out of the PEAR how it is been documented on http://pear.php.net   
  *
  * include_once("HTTP/Request.php");
  * include_once("File/CSV.php");
  * 
*/
include_once( "lib/ezutils/classes/ezdebug.php" );
include_once( "lib/ezutils/classes/ezini.php" );
include_once( "lib/ezutils/classes/ezsys.php" );

$powerlib  = new eZPowerLib();
if ( $powerlib->avialable )
{
	foreach ( $powerlib->avialable as $item )
	{
		$powerlib->loadlib($item);
	}
}
else
{
	eZDebug::writeWarning( "No Libraries loaded." , "eZPowerlib" );
}
class eZPowerLib
{	
	var $extension_base='';
	var $avialable=array();
	function eZPowerLib()
	{
		$ini = eZINI::instance( "ezpowerlib.ini", "extension/ezpowerlib/settings", null, true, true );
		$avialable = array();

		$this->extension_base = $ini->variable( "settings", "extension_base" );
		$this->avialable = $ini->variable( "settings", "avialable" );
	}
	function loadlib ($libname){
		if (empty($libname))
			return; 
			
		$ini = eZINI::instance( "ezpowerlib.ini", "extension/ezpowerlib/settings", null, true, true  );
		if (!$ini->hasSection($libname) )
			return;
		if( $ini->hasVariable($libname, "include_path") )
			$include_path = $ini->variable( $libname, "include_path" );
		if( $ini->hasVariable($libname, "include") )
			$include = $ini->variable( $libname, "include" );
		$includes =array();
		if( $ini->hasVariable($libname, $include) )
			$includes = $ini->variable( $libname, $include );
		#$GLOBAL['ezpowerlib_include_path_list'][] = ini_get('include_path');
		#var_dump( ini_get("include_path"));
		if (!empty($include_path))
			ini_set('include_path', realpath($include_path) .eZSys::envSeparator().ini_get('include_path'));

		$special_append_file = $this->extension_base.'/'.$libname.'.php' ;
		if ( file_exists ( $special_append_file ) )
		{
			include_once ( $special_append_file );
		}

		if (!empty($includes))
		{
			foreach ($includes as $file) 
			{
				include_once($this->extension_base.'/'.$file);
			}
		}
	}
}

?>