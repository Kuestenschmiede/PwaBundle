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

namespace con4gis\PwaBundle\Classes\Services;

use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\Config;
use Contao\Controller;
use Contao\Database;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceWorkerCreationService
{
    private $webPath = '';

    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * ServiceWorkerCreationService constructor.
     * @param string $webPath
     * @param ContainerInterface $container
     */
    public function __construct(string $webPath, ContainerInterface $container)
    {
        $this->webPath = $webPath;
        $this->container = $container;
    }

    public function createServiceWorker(PwaConfiguration $pwaConfiguration, PageModel $pageRoot)
    {
        $suffix = Config::get('url_suffix');
        $prependLocale = Config::get('prepend_locale');
        $locale = $pageRoot->language;
        $urlLocalePart = $prependLocale ? $locale . '/' : '';
        //TODO currently only one level deep
        $childPages = PageModel::findPublishedByPid($pageRoot->id, ['type' => 'regular']);

        $arrPagenames = [];

        if ($pwaConfiguration->getOfflinePage()) {
            $offlinePage = PageModel::findById($pwaConfiguration->getOfflinePage());
            $arrPagenames[] = $urlLocalePart . '/' . $offlinePage->alias . $suffix;
        }

        if (!($pwaConfiguration->getOfflinePage()) || ($pwaConfiguration->getOfflinePage() && $pwaConfiguration->getOfflineHandling() == 2)) {
            // cache all pages except the exceptions
            $pageIds = StringUtil::deserialize($pageRoot->uncachedPages, true);

            foreach ($childPages as $childPage) {
                if (!in_array($childPage->id, $pageIds) && $childPage->published == "1" && $childPage->alias != "") {
                    if ($prependLocale) {
                        $arrPagenames[] = $urlLocalePart . '/' . $childPage->alias . $suffix;
                    } else {
                        $arrPagenames[] = '/' . $childPage->alias . $suffix;
                    }
                }
            }
        }

        $version = Database::getInstance()
            ->prepare("SELECT version FROM tl_version WHERE fromTable = 'tl_page' AND pid = ? ORDER BY tstamp DESC LIMIT 1")
            ->execute($pageRoot->id)->fetchAssoc();
        if ($version && count($version) == 1) {
            $intVersion = $version['version'];
        } else {
            $intVersion = 1;
        }

        // check for additional urls to cache
        if ($pwaConfiguration->getAdditionalUrls()) {
            $additionalUrls = [];
            $arrUrls = explode(',', $pwaConfiguration->getAdditionalUrls());
            foreach ($arrUrls as $arrUrl) {
                $parser = System::getContainer()->get('contao.insert_tag.parser');
                $entries = explode(',', $parser->replace($arrUrl));
                foreach ($entries as $entry) {
                    $entry = str_replace('"','',$entry);
                    $entry = str_replace("'", "", $entry);
                    $additionalUrls[] = '/' . trim($entry);
                }
            }
            $arrPagenames = array_merge($arrPagenames, $additionalUrls);
        }

        $blockedUrls = [];
        // check for blocked urls
        if ($pwaConfiguration->getBlockedUrls()) {
            $blockedUrls = explode(',', $pwaConfiguration->getBlockedUrls());
        }

        $cacheName = 'pwa-con4gis-v' . $intVersion;

        $path = $this->webPath . '/sw' . str_pad($pwaConfiguration->getId(), 3, '0', STR_PAD_LEFT);
        $this->createServiceWorkerFile(
            $arrPagenames,
            $cacheName,
            $pwaConfiguration->getOfflinePage() ? $offlinePage->alias . $suffix : '',
            $pwaConfiguration->getOfflineHandling(),
            $blockedUrls,
            $path
        );
    }

    private function createServiceWorkerFile($arrPages, $cacheName, $strOfflinePage, $offlineHandling, $blockedUrls, $path)
    {
        $writer = new ServiceWorkerFileWriter();
        $writer->createServiceWorkerFile($arrPages, $cacheName, $path, $strOfflinePage, $offlineHandling, $blockedUrls);
    }
}
