<?php

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;
use con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback;

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
        'onsubmit_callback'			=> array
        (
            array('\con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback', 'sendNotification'),
            array('\con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback', 'truncateTable')
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
        'global_operations' => '',
        
        'operations' => array
        (
            'edit' => array
            (
                'label'         => $GLOBALS['TL_LANG']['tl_c4g_push_notification']['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.gif',
            )
        )
    ),
    
    // Palettes
    'palettes' => array
    (
        'default' => '{data_legend},messageTitle,messageContent;'
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
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
        'messageContent' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['messageContent'],
            'default'           => '',
            'inputType'         => 'textarea',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'sql'       => "varchar(255) NOT NULL default ''"
        ),
    )
);
