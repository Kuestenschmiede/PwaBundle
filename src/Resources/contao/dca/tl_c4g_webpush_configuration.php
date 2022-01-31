<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
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
        'onload_callback' => [['\con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback', 'showInfoMessage']],
        'onsubmit_callback'			=> array
        (
            array('\con4gis\PwaBundle\Classes\Callbacks\WebpushConfigurationCallback', 'writeDataToConfig'),
        )
    ),
    
    
    //List
    'list' => array
    (
        'sorting' => array
        (
            'mode'              => 2,
            'fields'            => array('name ASC'),
            'panelLayout'       => 'filter;sort,search,limit',
            'headerFields'      => array('name'),
            'icon'              => 'bundles/con4giscore/images/be-icons/con4gis_blue.svg',
        ),

        'label' => array
        (
            'fields'            => array('name'),
            'showColumns'       => true,
        ),

        'global_operations' => array
        (
            'all' => [
                'label'         => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'          => 'act=select',
                'class'         => 'header_edit_all',
                'attributes'    => 'onclick="Backend.getScrollOffSet()" accesskey="e"'
            ],
            'back' => [
                'href'                => 'key=back',
                'class'               => 'header_back',
                'button_callback'     => ['\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'back'],
                'icon'                => 'back.svg',
                'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
            ],
        ),

        'operations' => array
        (
            'edit' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.svg',
            ),
            'copy' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['copy'],
                'href'          => 'act=copy',
                'icon'          => 'copy.svg',
            ),
            'delete' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.svg',
                'attributes'    => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\')) return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'         => &$GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['show'],
                'href'          => 'act=show',
                'icon'          => 'show.svg',
            ),
        )
    ),
    
    // Palettes
    'palettes' => array
    (
        'default' => '{data_legend},name,vapidSubject,vapidPublickey,vapidPrivatekey,ttl,urgency,topic,batchSize,timeout,icon;'
    ),
    
    // Fields
    'fields' => array
    (
        'name' => [
            'label'             => &$GLOBALS['TL_LANG'][$strName]['name'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ],
        'vapidSubject' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['vapidSubject'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),
        'vapidPublickey' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['vapidPublickey'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
            'exclude'           => true
        ),
        'vapidPrivatekey' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['vapidPrivatekey'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
            'exclude'           => true
        ),
    
        'ttl' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['ttl'],
            'default'           => 2419200,
            'inputType'         => 'text',
            'eval'              => array('rgxp' => 'digit','mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),
    
        'urgency' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['urgency'],
            'default'           => 'normal',
            'inputType'         => 'select',
            'options_callback'  => [WebpushConfigurationCallback::class, 'getUrgencyOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),
    
        'topic' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['topic'],
            'default'           => 'message',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),

        'batchSize' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['batchSize'],
            'default'           => 1000,
            'inputType'         => 'text',
            'eval'              => array('rgxp' => 'digit','mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),

        'timeout' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['timeout'],
            'default'           => 30,
            'inputType'         => 'text',
            'eval'              => array('rgxp' => 'digit','mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ),
    
        'icon' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['icon'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true
        ),
        'importId' => array
        (
            'eval'              => array('doNotCopy' => true)
        ),
    )
);


