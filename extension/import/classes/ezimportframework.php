<?PHP
include_once( 'lib/ezutils/classes/ezextension.php' );
ext_class( 'import' ,  'ezimportprocess' );

class eZImportFramework
{
	var $processHandler;
	var $data;
	function eZImportFramework( )
	{

	}
	function &instance( $importSourceHandler )
	{
		$classname = "ez".$importSourceHandler."import";
		ext_class( "import" ,  $classname );
		$source = new $classname( );
		return $source;
	}
	function getData( $source , $namespace = false )
	{
		
	}
	function processData( $processHandler, $options=array(), $namespace = false )
	{
		$processHandlerImp = eZImportProcess::instance( $processHandler );
		$processHandlerImp->setOptions( $options );
		if ( $namespace ) 
			$processHandlerImp->run( $this->data[$namespace] );
		else
			$processHandlerImp->run( $this->data );
	}
}
?>