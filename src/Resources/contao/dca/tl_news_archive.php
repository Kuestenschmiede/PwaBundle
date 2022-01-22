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

use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

if (class_exists('Contao\NewsBundle\ContaoNewsBundle')) {
    $GLOBALS['TL_DCA']['tl_news_archive']['palettes']['__selector__'][] = 'pushOnPublish';
    
    $GLOBALS['TL_DCA']['tl_news_archive']['subpalettes']['pushOnPublish'] = 'subscriptionTypes';
    
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('pwa_legend', 'expert_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('pushOnPublish'), 'pwa_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_news_archive');
    
    
    $GLOBALS['TL_DCA']['tl_news_archive']['fields']['pushOnPublish'] = [
        'label'                   => &$GLOBALS['TL_LANG']['tl_news_archive']['pushOnPublish'],
        'exclude'                 => true,
        'default'                 => '',
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => true],
        'sql'                     => "char(1) NOT NULL default ''"
    ];
    
    $GLOBALS['TL_DCA']['tl_news_archive']['fields']['subscriptionTypes'] = [
        'label'             => &$GLOBALS['TL_LANG']['tl_news_archive']['subscriptionTypes'],
        'default'           => [],
        'inputType'         => 'select',
        'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
        'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
        'sql'               => "blob NULL",
        'exclude'           => true
    ];
    
}
