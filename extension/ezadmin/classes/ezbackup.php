<?php
include_once( 'lib/ezfile/classes/ezfile.php' );
include_once( 'lib/ezfile/classes/ezdir.php' );
include_once( 'lib/ezfile/classes/ezarchivehandler.php' );

class eZBackup
{
	var $time;
    var $data;
    function eZBackup( $options = array() )
    {
    	$this->data = $options;	
    	$this->time = time();
        $ini =& eZINI::instance('site.ini');
        $this->data['DatabaseSettings'] = $ini->group('DatabaseSettings');
        $this->data['SiteAccessSettings'] = $ini->group('SiteAccessSettings');
        
    }
    function remove()
    {
    	
    }
    function attribute( $name )
    {
    	switch ( $name )
    	{
    		case "path":
    			return eZSys::cacheDirectory().'/backup';
    		break;
    		case "archive":
    			if ( $this->data['compression'] == "gzip" )
    				return $this->attribute('path').'/'.$this->time.'.tgz';
    			if ( $this->data['compression'] == "bz2" )
    				return $this->attribute('path').'/'.$this->time.'.bz2';
    			return $this->attribute('path').'/'.$this->time.'.tar';
    		break;
    	}
    }
    function backup( $compression="gzip" )
    {
    	$this->data['compression'] = $compression;
    	eZDir::recursiveDelete( $this->attribute('path') );
        eZDir::mkdir( $this->attribute('path') );
        $sqlFile = $this->attribute('path'). '/' . $this->data['DatabaseSettings']['Database'].'.sql';
        
        if ( $this->data['DatabaseSettings']['Password'] )
    		$passstring = ' -p'.$this->data['DatabaseSettings']['Password'];
    	else
			$passstring='';
		$cmd='mysqldump --add-drop-table -n -h '.$this->data['DatabaseSettings']['Server'].' -u '.$this->data['DatabaseSettings']['User'].''.$passstring.' '.$this->data['DatabaseSettings']['Database'].' > ' . $sqlFile;

    	system( $cmd );
    	$archive = eZArchiveHandler::instance( 'tar', $compression, $this->attribute( 'archive' ) );
    	$fileList = array();
    	$fileList[] = $sqlFile;
    	$fileList[] = 'settings/override';
    	$fileList[] = eZSys::storageDirectory();
    	foreach($this->data['SiteAccessSettings']['AvailableSiteAccessList'] as $siteaccess )
    	{
    		$fileList[] ='settings/siteaccess/'.$siteaccess;
    	}
    	$fileList = array_unique( $fileList );
   		$archive->addModify( $fileList, '', '' );
   		@unlink( $sqlFile );
    }
    function download()
    {
    	eZFile::download( $this->attribute( 'archive' ) );
    }
    function restore ()
    {
    	$sys = & eZSys::instance();
        $sys->init();
        $dir = $sys->RootDir();
    	
    	
    	$db =& eZDB::instance();

    	system('mysql -h '.$this->data['DatabaseSettings']['Server'].' -u '.$this->data['DatabaseSettings']['User'].' -p'.$this->data['DatabaseSettings']['Password'].' '.$this->data['DatabaseSettings']['Database'].' < '.$this->data['DatabaseSettings']['Database'].'.sql');

    }
    function archive( $fileList, $archiveName, $destinationPath = false, $BaseDirectory='' )
	{

    	$archivePath = $archiveName;
    	if ( $destinationPath )
            $archivePath = $destinationPath . '/' . $archiveName;
    	$archive = eZArchiveHandler::instance( 'tar', 'gzip', $archivePath );

   		$archive->createModify( $fileList, '', $BaseDirectory );
        
		return $archivePath;
	}
	function unarchive( $to='' ,$archiveName,$destinationPath = false,$clean=false )
	{
		if ($clean)
		{
			eZDir::recursiveDelete( $to );
		}
		include_once( 'lib/ezfile/classes/ezarchivehandler.php' );
		$archivePath = $archiveName;
    	if ( $destinationPath )
        	    $archivePath = $destinationPath . '/' . $archiveName;
		$archive = eZArchiveHandler::instance( 'tar', 'gzip', $archivePath );
		$archive->extract($to);
	}

}
?>