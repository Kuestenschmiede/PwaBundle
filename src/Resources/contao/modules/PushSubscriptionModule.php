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

namespace con4gis\PwaBundle\Resources\contao\modules;


use con4gis\CoreBundle\Classes\ResourceLoader;
use con4gis\PwaBundle\Entity\PushSubscriptionType;
use Contao\BackendTemplate;
use Contao\Module;
use Contao\System;

class PushSubscriptionModule extends Module
{
    protected $strTemplate = "mod_push_subscription";
    
    public function generate()
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['push-subscription'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = System::getContainer()->get('router')->generate('contao_backend').'/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
    protected function compile()
    {
        // add manifest entry

        ResourceLoader::loadJavaScriptResource('bundles/con4gispwa/build/PushSubscription.js', ResourceLoader::HEAD);
        ResourceLoader::loadCssResource('bundles/con4gispwa/dist/css/push-subscription.min.css');
        $arrTypeIds = \Contao\StringUtil::deserialize($this->subscriptionTypes);
        $typeRepo = System::getContainer()->get('doctrine.orm.default_entity_manager')
            ->getRepository(PushSubscriptionType::class);
        foreach ($arrTypeIds as $id) {
            $type = $typeRepo->findOneBy(['id' => $id]);
            if ($type !== null) {
                $types[] = $type;
            }
        }

        $arrTypes = [];
        foreach ($types as $type) {
            $arrTypes[$type->getId()] = $type->getName();
        }

        $this->Template->subscriptionTypes = $arrTypes;
        $this->Template->disableSelection = $this->disableSelection;
        $this->Template->subscribeText = $this->subscribeText;
        $this->Template->unsubscribeText = $this->unsubscribeText;
        $this->Template->subscriptionType = $this->subscriptionType;
        $this->Template->moduleId = $this->id;
    }
}