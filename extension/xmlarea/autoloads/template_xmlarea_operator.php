<?php
/*!
  \class   TemplateAdd_xmlarea_attributesOperator templateadd_xmlarea_attributesoperator.php
  \ingroup eZTemplateOperators
  \brief   Handles template operator add_xmlarea_attributes. By using add_xmlarea_attributes you can...
  \version 1.0
  \date    Tuesday 30 November 2004 9:06:57 am
  \author  Administrator User

  

  Example:
\code
{$value|add_xmlarea_attributes('first',$input2)|wash}
\endcode
*/

/*
If you want to have autoloading of this operator you should create
a eztemplateautoload.php file and add the following code to it.
The autoload file must be placed somewhere specified in AutoloadPath
under the group TemplateSettings in settings/site.ini

$eZTemplateOperatorArray = array();
$eZTemplateOperatorArray[] = array( 'script' => 'templateadd_xmlarea_attributesoperator.php',
                                    'class' => '$full_class_name',
                                    'operator_names' => array( 'add_xmlarea_attributes' ) );

*/


class TemplateXMLAreaOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function TemplateXMLAreaOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'add_xmlarea_attributes', 
                      'xmlarea_custom_js',
                      'xmlarea_escape' );
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'add_xmlarea_attributes' => array( 'first_param' => array( 'type' => 'string',
                                                                                 'required' => false,
                                                                                 'default' => 'default text' ) ),
                      'xmlarea_custom_js' => array( 'first_param' => array( 'type' => 'string',
                                                                                 'required' => false,
                                                                                 'default' => '' ) ),
                      'xmlarea_escape' => array( 'first_param' => array( 'type' => 'string',
                                                                                 'required' => true,
                                                                                 'default' => 'default text' ) )  );
    }
    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        $firstParam = $namedParameters['first_param'];
        // Example code, this code must be modified to do what the operator should do, currently it only trims text.
        switch ( $operatorName )
        {
            case 'add_xmlarea_attributes':
            {
                $operatorValue = preg_replace('/alt=([^"]*)"/i', $firstParam,  $operatorValue );
                $operatorValue = preg_replace('/class=([^"]*)"/i', 'class="object"',  $operatorValue );
                
            } break;
            case 'xmlarea_escape':
            {
                $operatorValue = str_replace('"', '\\"', $operatorValue);
                $operatorValue = str_replace('\\\\"', '\\"', $operatorValue);
                $operatorValue = str_replace("\n", '\n', $operatorValue);
            } break;
            case 'xmlarea_custom_js':
            {

                include_once( "kernel/common/template.php" );
                include_once( "lib/ezutils/classes/ezini.php" );
                
                
                $tpl =& templateInit();
                //$Result = array();
                //$Result['pagelayout'] = '';
                
                
                $ini =& eZINI::instance( 'content.ini' );
                
                $availableTags =& $ini->variable( 'CustomTagSettings', 'AvailableCustomTags' );
                $inlines = $ini->variable( 'CustomTagSettings', 'IsInline' );
                $ini =& eZINI::instance( 'xmlarea.ini' );
                $xmlareaButtons =& $ini->variable( 'CustomTagSettings', 'xmlareaButtons' );
                $xmlareaPlugins =& $ini->variable( 'CustomTagSettings', 'xmlareaPlugins' );
                $tooltips =& $ini->variable( 'CustomTagSettings', 'Tooltips' );
                $icons =& $ini->variable( 'CustomTagSettings', 'Icons' );
                $startTags = $ini->variable( 'CustomTagSettings', 'StartTags' );
                $endTags = $ini->variable( 'CustomTagSettings', 'EndTags' );
                //$attributes = $ini->variable( 'CustomTagSettings', 'TagAttributes' );
                //$inlines = $ini->variable( 'CustomTagSettings', 'IsInline' );
                
                $tags = array();
                $tagNames = array();
                $buttons = array();
                $configs = array();
                $html = array();
                $validButtons = array(
                    'formatblock',
                    'space',
                    'undo',
                    'redo',
                    'separator',
                    'bold',
                    'italic',
                    'separator',
                    'insertorderedlist',
                    'insertunorderedlist',
                    'listoutdent',
                    'listindent',
                    'separator',
                    'createlink',
                    'insertanchor',
                    'insertobject',
                    'inserttable',
                    'contexttoggle',
                    'editmode',
                    'debug'
                );
                
                foreach ( $xmlareaButtons as $but )
                {
                    $but = strtolower( $but );
                    if ( strpos( $but, 'custom_' ) === 0 )
                        $but = substr( $but, 7 );
                    if ( in_array( $but, $validButtons ) )
                    {
                        $buttons[] = $but;
                    }
                    else if ( in_array( $but, $availableTags ) )
                    {
                        switch ( $but )
                        {
                            case ( 'sup' ) :
                                $buttons[] = 'superscript';
                                $tagNames[] = array( 'sup', 'Superscript' );
                                break;
                            case ( 'sub' ) :
                                $buttons[] = 'subscript';
                                $tagNames[] = array( 'sub', 'Subscript' );
                                break;
                            case ( 'strike' ) :
                                $buttons[] = 'strikethrough';
                                $tagNames[] = array( 'strike', 'Strikethrough' );
                                break;
                            case ( 'underline' ) :
                                $buttons[] = $but;
                                break;
                            default :
                                $buttons[] = 'custom_'.$but;
                                $tooltip = ( isset( $tooltips[$but] ) ) ? $tooltips[$but] : ucfirst($but);
                                $tagNames[] = array( $but, $tooltip );
                        }
                    }
                }
                
                foreach ( $availableTags as $tag )
                {
                        switch ( $tag )
                        {
                            case ( 'sup' ) :
                            case ( 'sub' ) :
                            case ( 'strike' ) :
                            case ( 'underline' ) :
                                break;
                            default :
                                    $starttag = ( isset( $startTags[$tag] ) ) ? $startTags[$tag] : '';
                                    $id = '';
                                    if ( $starttag == '' )
                                    {
                                        $starttag = ( isset( $inlines[$tag] ) && $inlines[$tag] ) ? 'span' : 'div';
                                        $id = $tag;
                                    }
                                    $image = 'images/';
                                    $image .= ( isset( $icons[$tag] ) ) ? $icons[$tag] : 'ed_question.gif';
                                    $custombuttons[] = 'custom_'.$tag;
                                    $configs[] = array( 'id' => 'custom_'.$tag,
                                                     'tag' => $id,
                                                     'tooltip' => ( isset( $tooltips[$tag] ) ) ? $tooltips[$tag] : ucfirst($tag),
                                                     'image' => $image,
                                                     'html' => $starttag,
                                                     'tag' => $tag );
                                    $tags[] = array( 'id' => 'custom_'.$tag,
                                                     'starttag' => $starttag,
                                                     'endtag' => ( isset( $endTags[$tag] ) ) ? $endTags[$tag] : '',
                                                     //'attributes' => ( isset( $attributes[$tag] ) ) ? $attributes[$tag] : '',
                                                     'inline' => ( isset( $inlines[$tag] ) && $inlines[$tag]  ) ? true : false,
                                                     'tag' => $tag );
                
                                break;
                        }
                        //if ( !in_array( $tag, $xmlareaButtons ) )
                        //{
                        //    array_pop( $custombuttons );
                        //}
                    //}
                    
                
                }
                
                $operatorValue = array( 'tags' => $tags,
                                        'tagNames' => $tagNames,
                                        'buttons' => $buttons,
                                        'configs' => $configs,
                                        'html' => $html,
                                        'plugins' => $xmlareaPlugins
                                         );
                
            } break;
        }
    }
}
?>