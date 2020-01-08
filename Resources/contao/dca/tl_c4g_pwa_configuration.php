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


/**
 * Table tl_c4g_pwa_configuration
 */

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;

$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_DCA'][$strName] = array
(
    //config
    'config' => array
    (
        'dataContainer'     => 'Table',
        'enableVersioning'  => 'true',
        'onload_callback'			=> array
        (
            array('\con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback', 'showHint'),
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
            'headerFields'      => array('name', 'type'),
        ),
        
        'label' => array
        (
            'fields'            => array('name'),
            'showColumns'       => true,
        ),
        
        'global_operations' => array
        (
            'all' => [
                'label'         => $GLOBALS['TL_LANG']['MSC']['all'],
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
                'label'         => $GLOBALS['TL_LANG'][$strName]['edit'],
                'href'          => 'act=edit',
                'icon'          => 'bundles/con4giscore/images/be-icons/edit.svg',
            ),
            'copy' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['copy'],
                'href'          => 'act=copy',
                'icon'          => 'copy.gif',
            ),
            'delete' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.gif',
                'attributes'    => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['show'],
                'href'          => 'act=show',
                'icon'          => 'show.gif',
            ),
        )
    ),
    
    //Palettes
    'palettes' => array
    (
        'default'   =>  '{data_legend},name,shortName,description,startUrl,scope,themeColor,backgroundColor,display,orientation,offlinePage,offlineHandling,icon192,icon512;{expert_legend},additionalUrls,blockedUrls;
        {ios_legend},iosStyle,appleIcon120,appleIcon152,appleIcon180,appleIcon167,splashIphoneFirst,splashIphoneSecond,splashIphoneThird,splashIphoneFourth,splashIpadFirst,splashIpadSecond,splashIpadThird;',
    ),
    
    //Fields
    'fields' => array
    (
        'name' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['name'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'shortName' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['shortName'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'description' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['description'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'startUrl' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['startUrl'],
            'default'           => '/',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'scope' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['scope'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'themeColor' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['themeColor'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'isHexColor'=>true, 'colorpicker'=>true, 'decodeEntities'=>true, 'tl_class'=>'long wizard')
        ),
    
        'backgroundColor' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['backgroundColor'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'isHexColor'=>true, 'colorpicker'=>true, 'decodeEntities'=>true, 'tl_class'=>'long wizard')
        ),
    
        'display' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['display'],
            'default'           => '0',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getDisplayOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true)
        ),
    
        'orientation' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['orientation'],
            'default'           => '0',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getOrientationOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true)
        ),
    
        'offlinePage' => array
        (
            'label'                   => $GLOBALS['TL_LANG'][$strName]['offlinePage'],
            'exclude'                 => true,
            'default'                 => 0,
            'inputType'               => 'pageTree',
            'eval'                    => ['fieldType'=>'radio'],
        ),
    
        'offlineHandling' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['offlineHandling'],
            'default'           => '1',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getOfflineHandlingOptions'],
            'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true)
        ),
    
        'icon192' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['icon192'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>true]
        ),
    
        'icon512' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['icon512'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>true]
        ),
    
        'additionalUrls' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['additionalUrls'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long')
        ),
    
        'blockedUrls' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['blockedUrls'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long')
        ),
    
        'iosStyle' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['iosStyle'],
            'default'           => 'black',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getIosStyleOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long')
        ),
    
        'appleIcon120' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['appleIcon120'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'appleIcon152' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['appleIcon152'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'appleIcon180' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['appleIcon180'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'appleIcon167' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['appleIcon167'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIphoneFirst' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIphoneFirst'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIphoneSecond' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIphoneSecond'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIphoneThird' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIphoneThird'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIphoneFourth' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIphoneFourth'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIpadFirst' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIpadFirst'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIpadSecond' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIpadSecond'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
    
        'splashIpadThird' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['splashIpadThird'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false]
        ),
        
    )
);

