<?php

include( 'PEAR.php' );
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, "eZPEARErrorHandling");
function eZPEARErrorHandling ( $error )
{
    if ( is_array( $error->backtrace ) and count( $error->backtrace ) > 1 )
    {
        $errorstring = "";
        for( $i=1; $i < count( $error->backtrace ) ; ++$i)
        {
            $error->backtrace[$i]['file'];
            $errorstring .= " in ". $error->backtrace[$i]['file'] . " in function " . $error->backtrace[$i]['function'] . " on line " . $error->backtrace[$i]['line'];
            if ( $i != ( count( $error->backtrace ) - 1 ) )
                $errorstring .= "\n";
        }
        eZDebug::writeError( $error->getMessage() . "\n" . $errorstring, PEAR_Error::getCallback() );   
    }
    else
    {
        eZDebug::writeError( $error->getMessage(), PEAR_Error::getCallback() );   
    }
}

?>