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
use Contao\Controller;
use Contao\FilesModel;
use Contao\System;

class ManifestCreationService
{
    private $webPath = '';
    /**
     * ManifestCreationService constructor.
     * @param $webPath
     */
    public function __construct($webPath)
    {
        $this->webPath = $webPath;
    }

    public function createManifestFile(PwaConfiguration $pwaConfiguration)
    {
        $path = str_pad($pwaConfiguration->getId(), 3, '0', STR_PAD_LEFT);
        if (!is_dir($this->webPath . '/' . $path)) {
            mkdir($this->webPath . '/' . $path);
        }

        //ToDo set language
        $parser = System::getContainer()->get('contao.insert_tag.parser');
        $language = $parser->replace('{{page::language}}') ?  Controller::replaceInsertTags('{{page::language}}') : substr($GLOBALS['_SERVER']['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if ($language === 'de' || strpos($language, 'de-')) {
            $language = 'de-DE';
        } else {
            $language = 'en-GB';
        }

        $jsonTemplate = [
            'dir' => 'ltr',
            'lang' => $language,
            'name' => '',
            'short_name' => '',
            'description' => '',
            'scope' => $pwaConfiguration->getScope(),
            'start_url' => $pwaConfiguration->getStartUrl(),
            'display' => '',
            'background_color' => '',
            'theme_color' => '',
            'icons' => [],
            'serviceworker' => [
                'src' => 'sw' . $path . '.js',
                'scope' => $pwaConfiguration->getScope(),
                'update_via_cache' => $pwaConfiguration->getUpdateViaCache(),
            ],
        ];
        $manifestJson = $this->parseFromConfiguration($jsonTemplate, $pwaConfiguration);

        $file = $this->webPath . '/' . $path . '/manifest.webmanifest';
        $this->writeManifestFile($file, $manifestJson);
    }

    private function parseFromConfiguration($arrJson, PwaConfiguration $configuration)
    {
        $arrJson['name'] = html_entity_decode($configuration->getName());
        $arrJson['short_name'] = html_entity_decode($configuration->getShortName());
        $arrJson['description'] = html_entity_decode($configuration->getDescription());
        $arrJson['display'] = $this->convertDisplayIdToManifestString($configuration->getDisplay());
        $arrJson['background_color'] = '#' . $configuration->getBackgroundColor();
        $arrJson['theme_color'] = '#' . $configuration->getThemeColor();
        $icon192 = FilesModel::findByUuid($configuration->getIcon192());
        $icon512 = FilesModel::findByUuid($configuration->getIcon512());
        $maskableIcon = FilesModel::findByUuid($configuration->getMaskableIcon());
        $arrJson['icons'] = [
            [
                'src' => '../' . $icon192->path,
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => '../' . $icon512->path,
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
            [
                'src' => '../' . $maskableIcon->path,
                'sizes' => $configuration->getMaskableIconSize(), // TODO dynamic
                'type' => 'image/png',
                'purpose' => 'any maskable',
            ],
        ];

        return $arrJson;
    }

    private function convertDisplayIdToManifestString($displayId)
    {
        switch ($displayId) {
            case PwaConfiguration::PWA_DISPLAY_FULLSCREEN:
                return 'fullscreen';

                break;
            case PwaConfiguration::PWA_DISPLAY_STANDALONE:
                return 'standalone';

                break;
            case PwaConfiguration::PWA_DISPLAY_MINIMAL_UI:
                return 'minimal-ui';

                break;
            case PwaConfiguration::PWA_DISPLAY_BROWSER:
                return 'browser';

                break;
            default:
                return 'browser';
        }
    }

    private function writeManifestFile($file, $arrData)
    {
        $content = json_encode($arrData, JSON_PRETTY_PRINT);
        file_put_contents($file, $content);
    }
}
