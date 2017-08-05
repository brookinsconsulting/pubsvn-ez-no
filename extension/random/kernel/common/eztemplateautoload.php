<?php

/*! \file eztemplateautoload.php
*/

// Operator autoloading

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'extension/random/kernel/common/templaterandomoperator.php',
                                    'class' => 'TemplateRandomOperator',
                                    'operator_names' => array( 'random' ) );

?>
