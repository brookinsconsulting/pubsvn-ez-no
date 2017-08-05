<?php
$Module = array( "name" => "MyModule", "variable_params" => true);

$ViewList = array();
$ViewList["hello"] = array(
        "script" => "hello.php",
        "params" => "",
        'post_action_parameters' => array( 'Generate' => array( 'Year' => 'Year',
                                                        'Month' => 'Month'
                                                            ) ),
        'single_post_actions' => array( 'GenerateButton' => 'Generate' ),
);
$FunctionList['hello'] = array( );
?>

