<?php
/*! \file templaterandomoperator.php
*/

/*!
  \class TemplateRandomOperator
  \brief The class TemplateRandomOperator gives you a random output. enjoy!
  \author Sören Meyer, xrow GbR
*/
class TemplateRandomOperator{
    var $Operators;

    function TemplateRandomOperator( $name = "random" ){
		$this->Operators = array( $name );
    }
    function &operatorList()
    {
		return $this->Operators;
    }


    function namedParameterPerOperator()
    {
        return true;
    } 
  
    function namedParameterList()
    {
        return array( 'random' => array( 'startnode' => array( 'type' => 'int',
                                                                 'required' => false,
                                                                 'default' => '0' ),
                                            'class' => array( 'type' => 'string',
                                                                 'required' => false,
                                                                 'default' => 'franchise' ),
					    'attribute_filter' => array( 'type' => 'array',
                                                                 'required' => false ),
					    'quantity' => array( 'type' => 'int',
                                                                 'required' => false,
                                                                 'default' => '0' ),
					    'sortbyname' => array( 'type' => 'string',
                                                                 'required' => false,
                                                                 'default' => 'false' ),
					    'fetchtype' => array( 'type' => 'string',
                                                                 'required' => false,
                                                                 'default' => 'tree' ) ) );
    }
    
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters ){
        
	$startnode = $namedParameters['startnode'];
	$class = $namedParameters['class'];
	$attribute_filter = $namedParameters['attribute_filter'];
	$quantity = $namedParameters['quantity'];
	$sortbyname = $namedParameters['sortbyname'];
	$fetchtype = $namedParameters['fetchtype'];

	// Count über Nodes für Max-offset!
	// Template-fetch übersetzen.
	include_once('kernel/content/ezcontentfunctioncollection.php');

	if($fetchtype=='tree')
	{
	    $array =& eZContentFunctionCollection::fetchObjectTreeCount( $startnode,
								    'include',
								    array( $class ),
								    $attribute_filter,
								    null,
								    null,
								    true );
	}
	else
	{
	    $array =& eZContentFunctionCollection::fetchObjectTreeCount( $startnode,
								    'include',
								    array( $class ),
								    $attribute_filter,
								    1,
								    'eq',
								    true );
	}
	$max = $array['result'];
	$result = array();
	$random_list = array();
	$i=0;
	if( $max!=0 )
	{
	    if ( $quantity > $max )
		 $quantity = $max;
	    while( $i < $quantity )
	    {
	        // Zufalls-offset generieren
	        
	        $offset = rand( 0, $max-1 );
	        $hinzu = true;
	        foreach( $random_list as $number )
	        {
		    if( $number == $offset )
			$hinzu=false;
	        }
	        
	        if( $hinzu )
	        {
		    $random_list[] = $offset;
		    if( $fetchtype == 'tree' )
		    {
			
			$komplett = eZContentFunctionCollection::fetchObjectTree( $startnode, null, $offset, 1, null, null,
			               null, $attribute_filter, null, 'include', array( $class ),
			               null, true, true );
		    }
		    if( $fetchtype=='list' )
		    {
		        $komplett = eZContentFunctionCollection::fetchObjectTree( $startnode, null, $offset, 1, 1, 'eq',
		                   null, $attribute_filter, null, 'include', array( $class ),
		                   null, true, true );
		    }
		    $result[$i] = $komplett['result'][0];
		    $i++;
		    
		}// If-Ende
	    }// For-Ende
	    // Sortieren..
	    
	    if( $sortbyname=='true' )
	    {
	        foreach ($result as $item)
	        {
		    $result_sorted[$item->Name]=$item;
	        }
		ksort ( $result_sorted );
		$i=0;
		foreach ($result_sorted as $key => $item)
		{
		    $new_result[$i]=$item;
		    $i++;
		}
		$operatorValue=$new_result;
	    }
	    else
	    {
		$operatorValue=$result;
	    }
	}
    }
}
?>
