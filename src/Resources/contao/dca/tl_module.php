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

use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;
use Contao\System;

$GLOBALS['TL_DCA']['tl_module']['palettes']['pwa'] = "{title_legend},name,type,pwaConfiguration,cronActivation";
$GLOBALS['TL_DCA']['tl_module']['palettes']['push-subscription'] = "{title_legend},name,type,subscribeText,unsubscribeText,subscriptionTypes,pushConfig,disableSelection,membersOnly";

$GLOBALS['TL_DCA']['tl_module']['fields']['pwaConfiguration'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['pwaConfiguration'],
    'default'           => 0,
    'inputType'         => 'select',
    'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'clr', 'includeBlankOption' => true),
    'sql'               => "int(10) unsigned NOT NULL default 0",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['subscribeText'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['subscribeText'],
    'default'           => 'Pushnachrichten abonnieren',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'clr'),
    'sql'               => "varchar(100) NOT NULL default ''",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['unsubscribeText'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['unsubscribeText'],
    'default'           => 'Abonnement bearbeiten',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'clr'),
    'sql'               => "varchar(100) NOT NULL default ''",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['subscriptionTypes'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['subscriptionTypes'],
    'default'           => [],
    'inputType'         => 'checkboxWizard',
    'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', /*'includeBlankOption' => true, */'multiple' => true/*, 'chosen' => true*/),
    'sql'               => "blob NULL",
    'xlabel'            => [['tl_c4g_pwa_module', 'typeLink']],
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['pushConfig'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['pushConfig'],
    'default'           => 0,
    'inputType'         => 'select',
    'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\SubscriptionTypeCallback', 'getPushConfigOptions'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
    'sql'               => "int(10) unsigned",
    'xlabel'            => [['tl_c4g_pwa_module', 'pushConfigLink']],
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['disableSelection'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['disableSelection'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cronActivation'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cronActivation'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['membersOnly'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['membersOnly'],
    'default'           => false,
    'inputType'         => 'checkbox',
    'eval'              => array('mandatory' => false, 'tl_class' => 'long'),
    'exclude'           => true,
    'sql'               => "char(1) NOT NULL default ''"
];

/**
 * Class tl_c4g_pwa_module
 */
class tl_c4g_pwa_module extends \Contao\Backend
{
    public function typeLink(Contao\DataContainer $dc)
    {
        $requestToken = System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
        return ' <a href="'.System::getContainer()->get('router')->generate('contao_backend').'?do=c4g_push_subscription_type&amp;table=tl_c4g_push_subscription_type&amp;id=' . $dc->activeRecord->pid . '&amp;popup=1&amp;nb=1&amp;rt=' . $requestToken . '" title="' . Contao\StringUtil::specialchars($GLOBALS['TL_LANG']['tl_module']['editSubscriptionType']) . '" onclick="Backend.openModalIframe({\'title\':\'' . Contao\StringUtil::specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['tl_module']['editSubscriptionType'])) . '\',\'url\':this.href});return false">' . Contao\Image::getHtml('edit.svg') . '</a>';
    }

    public function pushConfigLink(Contao\DataContainer $dc)
    {
        $requestToken = System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
        return ' <a href="'.System::getContainer()->get('router')->generate('contao_backend').'?do=c4g_webpush_configuration&amp;table=tl_c4g_webpush_configuration&amp;id=' . $dc->activeRecord->pid . '&amp;popup=1&amp;nb=1&amp;rt=' . $requestToken . '" title="' . Contao\StringUtil::specialchars($GLOBALS['TL_LANG']['tl_module']['editPushConfigurations']) . '" onclick="Backend.openModalIframe({\'title\':\'' . Contao\StringUtil::specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['tl_module']['editPushConfigurations'])) . '\',\'url\':this.href});return false">' . Contao\Image::getHtml('edit.svg') . '</a>';
    }
}