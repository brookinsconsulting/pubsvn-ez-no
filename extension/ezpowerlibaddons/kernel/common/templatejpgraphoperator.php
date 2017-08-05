<?php
//
/*!
  \class   TemplateJPGRAPHOperator templatejpgraphperator.php
  \ingroup eZTemplateOperators
  \brief   Handles generating images over the jpgraph interface

  \version 1.0
  \date    Thursday 16 March 2004 8:13:33 am


  \author  Bjoern Dieding, xrow GbR Hannover


  Example:
\code
Syntax:
{$data|jpgraph( hash(  function, "getDetails",
		   params, array('parameter1', $paramater1value, ...)
                   )
                )}
\endcode
*/



class TemplateJPGRAPHOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function TemplatJPGRAPHOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'jpgraph' );
    }


    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }



    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 	'jpgraph' => array(  'params' => array('type' => 'array',
											'required' => true,
											'default' => ''),
					     'values' => array('type' => 'array',
											'required' => false,
											'default' => ''),
					     'dimension' => array('type' => 'array',
											'required' => false,
											'default' => ''),
					     'bgcolor'  => array('type' => 'array',
											'required' => false,
											'default' => ''),
					     'werte'  => array('type' => 'string',
											'required' => false,
											'default' => ''),
					     'function' => array('type' => 'string',
											'required' => false,
											'default' => '')
											));

    }


    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {


      	$function = $namedParameters['function'];
	$parameters = $namedParameters['params'];
	$values = $namedParameters['values'];
	$dimension = $namedParameters['dimension'];
	$bgcolor=array();
	$bgcolor = $namedParameters['bgcolor'];
	$werte = $namedParameters['werte'];
	#var_dump($bgcolor);
	#var_dump($values);
        switch ( $operatorName )
        {
            case 'jpgraph':
            {
		$format=array("jpeg","jpg");
		#var_dump($operatorValue);
            include_once("extension/ezpowerlib/ezpowerlib.php");
		    // Get cache keys
			$params=array($operatorValue,$namedParameters);
    		if ( isset( $namedParameters ) )
    		{
        		$keyString = md5(serialize($params));
    		}
    		$dir=CACHE_DIR;
			$dateiname=$keyString.".".$format[1];
			if(is_array($dimension) and $dimension[0]>0 and $dimension[1]>0)
			{
			    $x=$dimension[0];
			    $y=$dimension[1];
			}
			else
			{
			    $x=1000;
			    $y=450;
			}
			$graph = new Graph($x,$y,'auto');
			$graph->img->SetAntiAliasing();
			$graph->img->SetQuality(100); 
			#$graph->img->SetImgFormat($format[0]);
			$graph->img->SetMargin(85,10,20,30); // links. rechts, Oben, unten
			$graph->SetScale("textlin");
			$graph->SetFrame(false);
			if(!$bgcolor) $bgcolor=array(255,255,255);
			$graph->SetColor($bgcolor);
			#$graph->SetMarginColor('white');
			#$graph->img->SetCanvasColor('green');
			$graph->img->SetTransparent('white'); // must be same color as above
#			$graph->img->SetTransparent(array(255,255,255));
			

$objekte=array();
#var_dump($operatorValue);
if(!empty($operatorValue)){
foreach ($operatorValue as $row){
	if (!$row['new']){ $row['new']='LinePlot'; }
	    $tmp=new $row['new']($row['data']);
	foreach ($row['attributes'] as $key => $value){
		$func = 'Set'.$key;
		$tmp->$func($value);
	}
	foreach ($row['objects'] as $obj => $objattributes){
		foreach ($objattributes as $key => $value){
			$func = 'Set'.$key;
			$tmp->$obj->$func($value);
		}
	}
    
	$graph->Add($tmp);
	unset($tmp);
	
}
}
		
		if(is_array($values)) $datax=$values;
		else $datax=array("","","","","","","","","","", "","","","");
		$graph->yscale->SetGrace(2);
		
		function yScaleCallback($aLabel) { 
		    return number_format($aLabel, 0, ',', '.'); 
		}
		function yScaleCallback_mio($aLabel) { 
		    $aLabel=$aLabel/1000000;    
		    return number_format($aLabel, 2, ',', '.'); 
		}
		function yScaleCallback_mio3($aLabel) { 
		    $aLabel=$aLabel/1000000;    
		    return number_format($aLabel, 3, ',', '.'); 
		}
		if(empty($werte)) $graph->yaxis->SetLabelFormatCallback('yScaleCallback');
		if($werte=="yScaleCallback_mio") $graph->yaxis->SetLabelFormatCallback('yScaleCallback_mio');
		if($werte=="yScaleCallback_mio3") $graph->yaxis->SetLabelFormatCallback('yScaleCallback_mio3');
		
		
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->SetTickLabels($datax);

		
		#$graph->SetFrame(true,'black',0);
		
		
		$graph->Stroke($dir.$dateiname);
		$result= eZSys::cacheDirectory()."/jpgraph/".$dateiname;
            	
		if(!$operatorValue){
		    eZDebug::writeError("Cannot process JPGRAPH-Interface: Error nr.","JPGRAPH Tempalte Operator");
		    $operatorValue= null;
		}else{
		    $operatorValue = $result;
		}
            }
	    break;
        }


    }
}
?>
