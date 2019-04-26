<?php


namespace con4gis\PwaBundle\Resources\contao\modules;


use con4gis\CoreBundle\Resources\contao\classes\ResourceLoader;
use Contao\Module;

class PushSubscriptionModule extends Module
{
    protected $strTemplate = "mod_push_subscription";
    
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['pwa'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
    protected function compile()
    {
        // add manifest entry
        ResourceLoader::loadJavaScriptResource('bundles/con4gispwa/js/PushSubscription.js', ResourceLoader::HEAD);
        $this->Template->subscribeText = $this->subscribeText;
        $this->Template->unsubscribeText = $this->unsubscribeText;
    }
}