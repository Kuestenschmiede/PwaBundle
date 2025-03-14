<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 10
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2025, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */


/**
 * Table tl_c4g_pwa_configuration
 */

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;
use Contao\DC_Table;

$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_DCA'][$strName] = array
(
    //config
    'config' => array
    (
        'dataContainer'     => DC_Table::class,
        'enableVersioning'  => true,
        'onload_callback'	=> array
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
                'label'         => &$GLOBALS['TL_LANG'][$strName]['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.svg',
            ),
            'copy' => array
            (
                'label'         => &$GLOBALS['TL_LANG'][$strName]['copy'],
                'href'          => 'act=copy',
                'icon'          => 'copy.svg',
            ),
            'delete' => array
            (
                'label'         => &$GLOBALS['TL_LANG'][$strName]['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.svg',
                'attributes'    => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\')) return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'         => &$GLOBALS['TL_LANG'][$strName]['show'],
                'href'          => 'act=show',
                'icon'          => 'show.svg',
            ),
        )
    ),
    
    //Palettes
    'palettes' => array
    (
        'default'   =>  '{data_legend},name,shortName,description,startUrl,scope,updateViaCache,themeColor,backgroundColor,display,orientation,offlinePage,offlineHandling,icon192,icon512,maskableIcon,maskableIconSize;{expert_legend},additionalUrls,blockedUrls;
        {ios_legend},iosStyle,appleIcon120,appleIcon152,appleIcon180,appleIcon167,splashIphoneFirst,splashIphoneSecond,splashIphoneThird,splashIphoneFourth,splashIpadFirst,splashIpadSecond,splashIpadThird;',
    ),
    
    //Fields
    'fields' => array
    (
        'name' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['name'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'shortName' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['shortName'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'description' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['description'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'startUrl' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['startUrl'],
            'default'           => '/',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'scope' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['scope'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),

        'updateViaCache' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['updateViaCache'],
            'default'           => 'imports',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getUpdateViaCacheOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => false),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'themeColor' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['themeColor'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'isHexColor'=>true, 'colorpicker'=>true, 'decodeEntities'=>true, 'tl_class'=>'clr wizard m12'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'backgroundColor' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['backgroundColor'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'isHexColor'=>true, 'colorpicker'=>true, 'decodeEntities'=>true, 'tl_class'=>'clr wizard m12'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'display' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['display'],
            'default'           => '0',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getDisplayOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'orientation' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['orientation'],
            'default'           => '0',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getOrientationOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'offlinePage' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['offlinePage'],
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'pageTree',
            'eval'                    => ['fieldType'=>'radio'],
            'sql'                     => null
        ),
    
        'offlineHandling' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['offlineHandling'],
            'default'           => 1,
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getOfflineHandlingOptions'],
            'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'icon192' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['icon192'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>true],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'icon512' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['icon512'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>true],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'maskableIcon' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['maskableIcon'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>true],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'maskableIconSize' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['maskableIconSize'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'additionalUrls' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['additionalUrls'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'blockedUrls' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['blockedUrls'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'iosStyle' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['iosStyle'],
            'default'           => 'black',
            'inputType'         => 'select',
            'options_callback'  => [PwaConfigurationCallback::class, 'getIosStyleOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true,
            'sql'               => null
        ),
    
        'appleIcon120' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['appleIcon120'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'appleIcon152' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['appleIcon152'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'appleIcon180' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['appleIcon180'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'appleIcon167' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['appleIcon167'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIphoneFirst' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIphoneFirst'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIphoneSecond' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIphoneSecond'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIphoneThird' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIphoneThird'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIphoneFourth' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIphoneFourth'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIpadFirst' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIpadFirst'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIpadSecond' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIpadSecond'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
    
        'splashIpadThird' => array
        (
            'label'             => &$GLOBALS['TL_LANG'][$strName]['splashIpadThird'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => [[PwaConfigurationCallback::class, 'convertBinToUuid']],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=> PwaConfigurationCallback::getAllowedImageExtensions(), 'tl_class'=>'clr', 'mandatory'=>false],
            'exclude'           => true,
            'sql'               => null
        ),
        'importId' => array
        (
            'eval'              => array('doNotCopy' => true),
            'sql'               => null
        ),
        
    )
);

