<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;
use con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback;

$strName = 'tl_c4g_webpush_configuration';
$GLOBALS['TL_DCA']['tl_c4g_webpush_configuration'] = array
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
            array('\con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback', 'loadDataset'),
        ),
        'onsubmit_callback'			=> array
        (
            array('\con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback', 'writeDataToConfig'),
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
                'label'         => $GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.svg',
            )
        )
    ),
    
    // Palettes
    'palettes' => array
    (
        'default' => '{data_legend},vapidSubject,vapidPublickey,vapidPrivatekey,ttl,urgency,topic,timeout,icon;'
    ),
    
    // Fields
    'fields' => array
    (
        'vapidSubject' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['vapidSubject'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
        'vapidPublickey' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['vapidPublickey'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long')
        ),
        'vapidPrivatekey' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['vapidPrivatekey'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long')
        ),
    
        'ttl' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['ttl'],
            'default'           => 2419200,
            'inputType'         => 'text',
            'eval'              => array('rgxp' => 'digit','mandatory' => true, 'tl_class' => 'long')
        ),
    
        'urgency' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['urgency'],
            'default'           => 'normal',
            'inputType'         => 'select',
            'options_callback'  => [WebpushConfigurationCallback::class, 'getUrgencyOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'topic' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['topic'],
            'default'           => 'message',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'timeout' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['timeout'],
            'default'           => 30,
            'inputType'         => 'text',
            'eval'              => array('rgxp' => 'digit','mandatory' => true, 'tl_class' => 'long')
        ),
    
        'icon' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['icon'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    )
);


