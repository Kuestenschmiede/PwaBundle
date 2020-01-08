<?php

use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

$strName = 'tl_c4g_push_notification';
$GLOBALS['TL_DCA']['tl_c4g_push_notification'] = array
(
    
    // Config
    'config' => array
    (
        'dataContainer'     => 'Table',
        'enableVersioning'  => false,
        'notDeletable' => true,
        'notCopyable' => true,
        'closed' => (\Input::get('id')),
        'onload_callback'			=> array
        (
            array(PushNotificationCallback::class, 'loadDataset'),
        ),
        'onsubmit_callback'			=> array
        (
            array(PushNotificationCallback::class, 'sendNotification'),
            array(PushNotificationCallback::class, 'truncateTable')
        ),
        'sql'               => array
        (
            'keys' => array
            (
                'id' => 'primary',
            )
        )
    ),
    
    
    //List
    'list' => array
    (
        'global_operations' => [
            'back' =>
                [
                    'href'                => 'key=back',
                    'class'               => 'header_back',
                    'button_callback'     => ['\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'back'],
                    'icon'                => 'back.svg',
                    'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
                ],
        ],
        'operations' => array
        (
            'edit' => array
            (
                'label'         => $GLOBALS['TL_LANG']['tl_c4g_push_notification']['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.svg',
            )
        )
    ),
    
    // Palettes
    'palettes' => array
    (
        'default' => '{data_legend},messageTitle,messageContent,subscriptionTypes;'
    ),
    
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
    
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'messageTitle' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['messageTitle'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'sql'               => "varchar(255) NOT NULL default ''"
        ),
        'messageContent' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['messageContent'],
            'default'           => '',
            'inputType'         => 'textarea',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'sql'               => "varchar(255) NOT NULL default ''"
        ),
        'subscriptionTypes' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['subscriptionTypes'],
            'default'           => [],
            'inputType'         => 'select',
            'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
            'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
            'sql'               => "blob NULL"
        )
    )
);
