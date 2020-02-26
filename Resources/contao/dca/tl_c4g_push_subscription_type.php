<?php

use con4gis\PwaBundle\Classes\Callbacks\PwaConfigurationCallback;

$strName = 'tl_c4g_push_subscription_type';

$GLOBALS['TL_DCA'][$strName] = array
(
    //config
    'config' => array
    (
        'dataContainer'     => 'Table',
        'enableVersioning'  => true
    ),
    
    //List
    'list' => array
    (
        'sorting' => array
        (
            'mode'              => 2,
            'fields'            => array('name ASC'),
            'panelLayout'       => 'filter;sort,search,limit',
            'headerFields'      => array('name', 'pushConfig'),
            'icon'              => 'bundles/con4giscore/images/be-icons/con4gis_blue.svg',
        ),
        
        'label' => array
        (
            'fields'            => array('name', 'pushConfig:tl_c4g_webpush_configuration.name'),
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
                'icon'          => 'edit.svg',
            ),
            'copy' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['copy'],
                'href'          => 'act=copy',
                'icon'          => 'copy.svg',
            ),
            'delete' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.svg',
                'attributes'    => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false;Backend.getScrollOffset()"',
            ),
            'show' => array
            (
                'label'         => $GLOBALS['TL_LANG'][$strName]['show'],
                'href'          => 'act=show',
                'icon'          => 'show.svg',
            ),
        )
    ),
    
    //Palettes
    'palettes' => array
    (
        'default'   =>  '{data_legend},name,pushConfig;'
    ),
    
    //Fields
    'fields' => array
    (
        'name' => [
            'label'             => $GLOBALS['TL_LANG'][$strName]['name'],
            'default'           => '',
            'inputType'         => 'text',
            'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
            'exclude'           => true
        ],
        'pushConfig' => [
            'label'             => $GLOBALS['TL_LANG'][$strName]['pushConfig'],
            'default'           => '0',
            'inputType'         => 'select',
            'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\SubscriptionTypeCallback', 'getPushConfigOptions'],
            'eval'              => array('mandatory' => true, 'tl_class' => 'long', 'includeBlankOption' => true),
            'sql'               => "int(10) unsigned NOT NULL default '0'",
            'xlabel'            => [[$strName, 'pushConfigLink']],
            'exclude'           => true
        ],
        'importId' =>
        [
           'eval'               => array('doNotCopy' => true)
        ]
    )
);

/**
 * Class tl_content_c4g_maps
 */
class tl_c4g_push_subscription_type extends Backend
{

    public function pushConfigLink(Contao\DataContainer $dc)
    {
        return ' <a href="contao/main.php?do=c4g_webpush_configuration&amp;table=tl_c4g_webpush_configuration&amp;id=' . $dc->activeRecord->pid . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . Contao\StringUtil::specialchars($GLOBALS['TL_LANG']['tl_c4g_push_subscriptions_type']['editPushConfigurations']) . '" onclick="Backend.openModalIframe({\'title\':\'' . Contao\StringUtil::specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['tl_c4g_push_subscriptions_type']['editPushConfigurations'])) . '\',\'url\':this.href});return false">' . Contao\Image::getHtml('edit.svg') . '</a>';
    }
}


