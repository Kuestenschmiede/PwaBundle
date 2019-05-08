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

namespace con4gis\PwaBundle\Classes\Services;


use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\FilesModel;

class ManifestCreationService
{
    
    private $webPath = "";
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
        $jsonTemplate = [
            "dir" => "ltr",
            "lang" => "de-DE",
            "name" => "",
            "short_name" => "",
            "description" => "",
            "scope" => $pwaConfiguration->getScope(),
            "start_url" => $pwaConfiguration->getStartUrl(),
            "display" => "",
            "background_color" => "",
            "theme_color" => "",
            "icons" => [],
            "serviceworker" => [
                "src" => "/sw.js",
                "scope" => ".",
                "update_via_cache" => "none"
            ]
        ];
        $manifestJson = $this->parseFromConfiguration($jsonTemplate, $pwaConfiguration);
        $path = $this->webPath . '/manifest.webmanifest';
        $this->writeManifestFile($path, $manifestJson);
    }
    
    private function parseFromConfiguration($arrJson, PwaConfiguration $configuration)
    {
        $arrJson['name'] = $configuration->getName();
        $arrJson['short_name'] = $configuration->getShortName();
        $arrJson['description'] = $configuration->getDescription();
        $arrJson['display'] = $this->convertDisplayIdToManifestString($configuration->getDisplay());
        $arrJson['background_color'] = '#' . $configuration->getBackgroundColor();
        $arrJson['theme_color'] = '#' . $configuration->getThemeColor();
        $icon192 = FilesModel::findByUuid($configuration->getIcon192());
        $icon512 = FilesModel::findByUuid($configuration->getIcon512());
        $arrJson['icons'] = [
            [
                "src" => $icon192->path,
                "sizes" => "192x192",
                "type" => "image/png"
            ],
            [
                "src" => $icon512->path,
                "sizes" => "512x512",
                "type" => "image/png"
            ]
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
                return "browser";
        }
    }
    
    private function writeManifestFile($path, $arrData)
    {
        file_put_contents($path, json_encode($arrData, JSON_PRETTY_PRINT));
    }
}