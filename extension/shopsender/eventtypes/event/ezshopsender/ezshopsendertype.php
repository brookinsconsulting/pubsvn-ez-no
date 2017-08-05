<?php
//
// Definition of Shopsender class
//
// Created on: <12-12-2003 19:16:50 bjoern>
//
// Copyright (C) 2003 xrow GbR. All rights reserved.
//

/*! \file ezshopsendertype.php
*/

/*!
  \class eZWrappingType ezwrappingtype.php
  \brief The class eZWrappingType does

*/
include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'kernel/classes/ezorderitem.php' );
include_once( "kernel/classes/ezorder.php" );
include_once( "kernel/classes/datatypes/ezuser/ezuser.php" );

define( "EZ_WORKFLOW_TYPE_SHOPSENDER_ID", "ezshopsender" );

class eZShopsenderType extends eZWorkflowEventType
{
    /*!
     Constructor
    */
    function eZShopsenderType()
    {
        $this->eZWorkflowEventType( EZ_WORKFLOW_TYPE_SHOPSENDER_ID, ezi18n( 'kernel/workflow/event', "Shopsender" ) );
    }
    function execute( &$process, &$event )
    {
        $parameters =& $process->attribute( 'parameter_list' );
        $http =& eZHTTPTool::instance();

        eZDebug::writeNotice( $parameters, "parameters" );
        $orderID = $parameters['order_id'];
        $order = eZOrder::fetch( $orderID );
        
        if (empty($orderID) || get_class( $order ) != 'ezorder')
        {
            eZDebug::writeWarning( "Can't proceed without a Order ID.", "Shopsender" );
            return EZ_WORKFLOW_TYPE_STATUS_FETCH_TEMPLATE_REPEAT;
        }
        $result = array();
        $productCollection = $order->productCollection();
        $ordereditems = $productCollection->itemList();
        foreach ($ordereditems as $item){
            $co = $item->contentObject();
            $result[$co->attribute("owner_id")]["ow"]=& eZUser::fetch($co->attribute("owner_id"));
            $result[$co->attribute("owner_id")]["order"]=$order;
            $result[$co->attribute("owner_id")]["plist"]=$item;
            $result[$co->attribute("owner_id")]["ids"][]=$co->attribute("id");
        }
        foreach ($result as $emailtosend){
            $this->domail($orderID,$emailtosend);
        }
        return EZ_WORKFLOW_TYPE_STATUS_ACCEPTED;
        
    /**   $requestUri = eZSys::requestUri();
        $process->Template = array( 'templateName' => 'design:workflow/eventtype/result/' . 'event_ezshopsender' . '.tpl',
                                    'templateVars' => array( 'request_uri' => $requestUri )
                                     );
//        $event->setAttribute( 'status', EZ_WORKFLOW_TYPE_STATUS_FETCH_TEMPLATE );
        return EZ_WORKFLOW_TYPE_STATUS_FETCH_TEMPLATE_REPEAT;*/
    }
    function domail( $orderID, $ostruct ){
        $order =& eZOrder::fetch( $orderID );
        // Fetch the shop account handler
        include_once( 'kernel/classes/ezshopaccounthandler.php' );
        $accountHandler =& eZShopAccountHandler::instance();
        $email = $ostruct["ow"]->attribute('email');
        eZDebug::writeDebug( $email,  'email' );
        
        include_once( "kernel/common/template.php" );
        #$tpl =& eZTemplate::instance();
        $tpl =& templateInit();
        $tpl->setVariable( 'order', $order );
        $tpl->setVariable( 'ostruct', $ostruct );
        
        $templateResult = & $tpl->fetch( 'extension/shopsender/design/standard/templates/workflow/eventtype/result/orderemail.tpl' );
        
        $subject =& $tpl->variable( 'subject' );

        $receiver = $email;

        include_once( 'lib/ezutils/classes/ezmail.php' );
        include_once( 'lib/ezutils/classes/ezmailtransport.php' );
        $ini =& eZINI::instance();
        $mail = new eZMail();

        if ( !$mail->validate( $receiver ) )
        {
        }
        $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
        if ( !$emailSender )
            $emailSender = $ini->variable( "MailSettings", "AdminEmail" );

        $mail->setReceiver( $email );
        $mail->setSender( $emailSender );
        $mail->setSubject( $subject );
        $mail->setBody( $templateResult );
        $mailResult = eZMailTransport::send( $mail );


        $email = $ini->variable( 'MailSettings', 'AdminEmail' );

        $mail = new eZMail();

        if ( !$mail->validate( $receiver ) )
        {
        }

        $mail->setReceiver( $email );
        $mail->setSender( $emailSender );
        $mail->setSubject( $subject );
        $mail->setBody( $templateResult );
        $mailResult = eZMailTransport::send( $mail );
    }
}

eZWorkflowEventType::registerType( EZ_WORKFLOW_TYPE_SHOPSENDER_ID, "ezshopsendertype" );

?>
