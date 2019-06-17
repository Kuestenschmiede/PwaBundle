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

namespace con4gis\PwaBundle\Resources\contao\modules;


use con4gis\CoreBundle\Resources\contao\classes\ResourceLoader;
use con4gis\PwaBundle\Entity\PushSubscriptionType;
use Contao\Module;
use Contao\System;

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
        $this->Template->subscriptionType = $this->subscriptionType;
    }
}