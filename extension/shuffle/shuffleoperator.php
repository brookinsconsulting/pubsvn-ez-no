<?php

/*! \file shuffleoperator.php
*/

/*!
  \class shuffleOperator shuffleoperator.php
  \brief The class shuffleoperator takes an array, and randomises its order. enjoy!
  \author Tim Ross
*/
class shuffleOperator
{
    var $Operators;

    function shuffleOperator( $name = "shuffle" )
    {
	$this->Operators = array( $name );
    }

    /*! Returns the template operators.
    */
    function &operatorList()
    {
	return $this->Operators;
    }

    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
	shuffle($operatorValue);
    }
}

?>
