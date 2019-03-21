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
$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_DCA'][$strName] = array
(
    //config
    'config' => array
    (
        'dataContainer'     => 'Table',
        'enableVersioning'  => 'true'
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
            'all' => array
            (
                'label'         => $GLOBALS['TL_LANG']['MSC']['all'],
                'href'          => 'act=select',
                'class'         => 'header_edit_all',
                'attributes'    => 'onclick="Backend.getScrollOffSet()" accesskey="e"'
            )
        ),
        
        'operations' => array
        (
            'edit' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['edit'],
                'href'          => 'act=edit',
                'icon'          => 'edit.gif',
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
        'default'   =>  '{data_legend},name,shortName,description,themeColor,backgroundColor,display,icon192,icon512;',
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
            'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback', 'getDisplayOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true)
        ),
    
        'icon192' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['icon192'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => ['con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback', 'binToUuid'],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>'png', 'tl_class'=>'clr', 'mandatory'=>true]
        ),
    
        'icon512' => array
        (
            'label'             => $GLOBALS['TL_LANG'][$strName]['icon512'],
            'default'           => '',
            'inputType'         => 'fileTree',
            'save_callback'     => ['con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback', 'binToUuid'],
            'eval'              => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>'png', 'tl_class'=>'clr', 'mandatory'=>true]
        ),
    )
);

