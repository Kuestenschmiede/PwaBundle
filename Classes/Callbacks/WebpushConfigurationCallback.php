<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\Backend;
use Contao\DataContainer;
use Database;

class WebpushConfigurationCallback extends Backend
{
    public function loadDataset()
    {
        $objConfig = Database::getInstance()->prepare("SELECT id FROM tl_c4g_webpush_configuration")->execute();
        
        if (\Input::get('key')) return;
        
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
            WebPushConfiguration::URGENCY_VERY_LOW =>$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW],
            WebPushConfiguration::URGENCY_LOW =>$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW],
            WebPushConfiguration::URGENCY_NORMAL =>$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL],
            WebPushConfiguration::URGENCY_HIGH =>$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH]
        ];
    }
    
    public function writeDataToConfig(DataContainer $dc)
    {
        // TODO create $rootDir/app/config/config.yml or check it's existence
        // TODO build the yaml structure for the config options
        // TODO write to the file (and clear the cache/hint the user to clear the cache?)
    }
}