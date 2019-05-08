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

namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\Backend;
use Contao\DataContainer;
use Contao\System;
use Database;
use Minishlink\WebPush\VAPID;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class WebpushConfigurationCallback extends Backend
{
    public function loadDataset()
    {
        $objConfig = Database::getInstance()->prepare("SELECT id FROM tl_c4g_webpush_configuration")->execute();
        
        if (\Input::get('key')) {
            return;
        }
        
        if(!$objConfig->numRows && !\Input::get('act'))
        {
            $this->redirect($this->addToUrl('act=create'));
        }
        
        
        if(!\Input::get('id') && !\Input::get('act'))
        {
            $GLOBALS['TL_DCA']['tl_c4g_webpush_configuration']['config']['notCreatable'] = true;
            $this->redirect($this->addToUrl('act=edit&id='.$objConfig->id));
        }
        
        \Contao\Message::addInfo($GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['infotext']);
    }
    
    public function getUrgencyOptions()
    {
        $strName = 'tl_c4g_webpush_configuration';
        return [
            WebPushConfiguration::URGENCY_VERY_LOW => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW],
            WebPushConfiguration::URGENCY_LOW => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW],
            WebPushConfiguration::URGENCY_NORMAL => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL],
            WebPushConfiguration::URGENCY_HIGH => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH]
        ];
    }
    
    public function writeDataToConfig(DataContainer $dc)
    {
        $extensionName = 'minishlink_web_push';
        
        if (!($dc->activeRecord->vapidPublickey && $dc->activeRecord->vapidPrivatekey)) {
            // both keys are required, so create a new pair
            $keys = VAPID::createVapidKeys();
            $publicKey = $keys['publicKey'];
            $privateKey = $keys['privateKey'];
            $this->Database->prepare("UPDATE tl_c4g_webpush_configuration SET vapidPublickey=?, vapidPrivatekey=? WHERE id=? ")
                ->execute($publicKey, $privateKey, $dc->activeRecord->id);
        } else {
            // use the user specified keys
            $publicKey = html_entity_decode($dc->activeRecord->vapidPublickey);
            $privateKey = html_entity_decode($dc->activeRecord->vapidPrivatekey);
        }
        
        // configuration array that will be written to yaml
        $config = [];
        $config[$extensionName] = [];
        $config[$extensionName]['VAPID'] = [
            'subject' => $dc->activeRecord->vapidSubject,
            'publicKey' => $publicKey,
            'privateKey' => $privateKey
        ];
        $config[$extensionName]['ttl'] = intval($dc->activeRecord->ttl);
        $config[$extensionName]['urgency'] = $dc->activeRecord->urgency;
        $config[$extensionName]['topic'] = $dc->activeRecord->topic;
        $config[$extensionName]['timeout'] = intval($dc->activeRecord->timeout);
        // always set to true for better security (leads to higher payload though)
        $config[$extensionName]['automatic_padding'] = true;
        
        $rootDir = System::getContainer()->getParameter('kernel.project_dir');
        $configFile = $rootDir . '/app/config/config.yml';
        try {
            $currentConfig = Yaml::parseFile($configFile);
        } catch (ParseException $exception) {
            // parsing was not successful
            $currentConfig = [];
        }
        $updatedConfig = Yaml::dump(array_merge($currentConfig, $config));
        file_put_contents($configFile, $updatedConfig);
    }
}