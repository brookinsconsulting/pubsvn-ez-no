<?php


$Module = array( 'name' => 'xmlarea' );

$ViewList = array();

$ViewList['xmlhttp'] = array(
    'script' => 'xmlhttp.php',
    'params' => array( 'Func' ),
    'default_navigation_part' => 'ezsetupnavigationpart');

$ViewList['js_test'] = array(
    'script' => 'js_test.php',
    'default_navigation_part' => 'ezsetupnavigationpart');

$ViewList['object'] = array(
    'script' => 'object.php',
    'params' => array( 'ObjectID', 'ObjectVer', 'ObjectLang', 'InsertParams' ),
    'default_navigation_part' => 'ezsetupnavigationpart');

$ViewList['tag'] = array(
    'script' => 'tag.php',    
    'params' => array( 'TagName', 'FancyName', 'Params' ),
    'default_navigation_part' => 'ezsetupnavigationpart');

$ViewList['relation'] = array(
    'script' => 'relation.php',
    'single_post_actions' => array( 'BrowseObjectButton' => 'BrowseForObjects',
                                    'UploadFileRelationButton' => 'UploadFileRelation',
                                    'CancelUploadButton' => 'CancelUpload'
                                  ),
    'post_action_parameters' => array( 'UploadFileRelation' => array( 'UploadRelationLocation' => 'UploadRelationLocationChoice' ) ),
    'post_actions' => array( 'BrowseActionName' ),
    'params' => array( 'ObjectID', 'EditVersion', 'EditLanguage', 'InsertParams' ),
    'default_navigation_part' => 'ezsetupnavigationpart');

?>