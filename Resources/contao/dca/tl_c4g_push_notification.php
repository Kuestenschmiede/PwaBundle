<?php

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;
use con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback;
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
            array('tl_c4g_push_notification', 'loadDataset'),
        ),
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

/**
 * Class tl_c4g_settings
 */
class tl_c4g_push_notification extends Backend
{
    public function loadDataset()
    {
        $objConfig = Database::getInstance()->prepare("SELECT id FROM tl_c4g_push_notification")->execute();

        if (\Input::get('key')) return;

        if(!$objConfig->numRows && !\Input::get('act'))
        {
            $this->redirect($this->addToUrl('act=create'));
        }


        if(!\Input::get('id') && !\Input::get('act'))
        {
            $GLOBALS['TL_DCA']['tl_c4g_push_notification']['config']['notCreatable'] = true;
            $this->redirect($this->addToUrl('act=edit&id='.$objConfig->id));
        }

        \Message::addInfo($GLOBALS['TL_LANG']['tl_c4g_push_notification']['infoText']);
    }
}

