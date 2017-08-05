<?php
class eZSVN
{
    function eZSVN ()
    {

    }
    function execute( $params )
    {
    	$execute=true;
    	$sys = & eZSys::instance();
        $sys->init();
        $root = $sys->RootDir();
        $ini = & eZINI::instance('svn.ini');
        $executeablearray = $ini->variable( 'Settings', 'executeable' );
		$executeable = $executeablearray[$sys->osType()];

		if( empty($executeable) )
		{
			eZDebug::writeWarning( 'Extension might not be activated.','eZSVN::execute()' );
			$ini = & eZINI::instance('svn.ini', 'extension/ezsvn/settings' );
			$executeablearray = $ini->variable( 'Settings', 'executeable' );
			$executeable = $executeablearray[$sys->osType()];
		}

		$executeable = eZDIR::convertSeparators( $executeable, EZ_DIR_SEPARATOR_LOCAL );
        $cmd="";
        switch ($params['type'])
        {
        	case 'export':
        		$cmd .= " export --force";
        	break;
        	case 'co':
        		$cmd .= " co";
        	break;
        	default:
        		$cmd .= " --help";
        		$execute=false;
        	break;
        }
        if ( isset( $params['user'] ) and isset( $params['password'] ) )
        {
        	$cmd .= " --username ".$params['user']." --password ".$params['password'];
        }
        if ( isset( $params['revision'] ) )
        {
        	$cmd .= " --revision ".$params['revision'];
        }
        if ( $params['url'] )
        {
        	$cmd .= " ".$params['url'];
        }
        if ( $params['placement'] )
        {
        	$path=$root."/".$params['placement'];
        	$cmd .= " ".eZDir::cleanPath( $path, EZ_DIR_SEPARATOR_UNIX );
        }
        else
        {
        	$cmd .= " ".eZDir::cleanPath( $root, EZ_DIR_SEPARATOR_UNIX );
        }
        if ( empty( $params['url'] ) )
        {
        	$execute=false;
        }
        if ( $execute==true )
        {
				$cmd = $executeable.$cmd;
				eZDebug::writeNotice( $cmd, "eZSVN::execute" );
        		$retval=null;
        		$last_line = system($cmd, $retval);
				if ( $params['type'] == 'export' and array_key_exists( "name", $params ) and $ini->variable( 'Settings', 'AutoClean' ) == 'enabled' and $ini->hasVariable( 'AutoClean', $params['name'] ) )
				{
					$items = $ini->variable( 'AutoClean', $params['name'] );
					foreach ( $items as $item )
					{
						if ( empty( $item ) or $item[0] == "/" or $item == "." or $item == "..")
							continue;
						if ( is_dir( $item ) )
						{
							eZDir::recursiveDelete( $item );
						}
						elseif ( file_exists( $item ) )
						{
							unlink( $item );
						}
					}
				}
        		return $retval;
        }
        else
        {
        	return false;	
        }
    }
    function update ( $repositories )
    {	
    	foreach ( $repositories as $repository )
    	{
    		eZSVN::execute( $repository );
    	}
    }
}
?>