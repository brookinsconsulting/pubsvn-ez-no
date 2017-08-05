<?php

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array( 'script' => 'kernel/common/ezmoduleparamsoperator.php',
                                    'class' => 'ezmoduleparamsoperator',
                                    'operator_names' => array( 'module_params' ) );
$eZTemplateOperatorArray[] = array( 'script' => 'extension/xmlarea/autoloads/template_xmlarea_operator.php',
                                    'class' => 'TemplateXMLAreaOperator',
                                    'operator_names' => array( 'add_xmlarea_attributes',
                                                               'xmlarea_custom_js',
                                                               'xmlarea_escape' ) );
?>