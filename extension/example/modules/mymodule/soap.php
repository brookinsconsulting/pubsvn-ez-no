<?php
/*
   This is an example of a soap interface that works together with the generic soap server.
   http://pubsvn.ez.no/viewcvs/community/trunk/extension/soap/
*/
class eZSOAPmymodule
{
    function eZSOAPmymodule()
    {
    }
    function add ( $a , $b )
    {
        $return = $a + $b;
        return $return;
    }
}
?>