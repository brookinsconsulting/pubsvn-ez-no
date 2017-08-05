<?php
include_once("extension/ezpowerlib/ezpowerlib.php");
include_once("File/CSV.php");
    
class eZCVSImport extends eZImportFramework 
{
    function eZCVSImport( $processHandler )
    {
        parent::eZImportFramework( $processHandler );
    }
    function getData( $file, $namespace = false )
    {
        $conf = File_CSV::discoverFormat( $file );

        while( $row = File_CSV::read($file, $conf) )
        {
            if ( !empty( $row ) )
            $fields[] = $row;
        }
        $meta  = array_shift($fields);

        for ( $i=0; $i<=count($fields); $i++ ){
            if ( $i==0 )
                continue;
            if ( count($fields[1])>0 )
            {
                for( $j=0;$j<count($fields[$i]);$j++ )
                {
                    if ( trim( $fields[$i][$j] ) )
                    {
                        $result[$i][strtolower(trim($meta[$j]))] = trim($fields[$i][$j]);
                    }
                    else 
                    {
                        $result[$i][strtolower(trim($meta[$j]))] = null;
                    }
                }
            }
        }
        if ( $namespace )
            $this->data[$namespace] = array_merge( $this->data, $result );
        else
            $this->data = array_merge( $this->data[$namespace], $result );
    }
}
?>