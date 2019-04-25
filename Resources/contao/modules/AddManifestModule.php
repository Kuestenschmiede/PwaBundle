<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 20.03.19
 * Time: 16:45
 */

namespace con4gis\PwaBundle\Resources\contao\modules;


use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\FilesModel;
use Contao\Module;
use Contao\System;

class AddManifestModule extends Module
{
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
        $GLOBALS['TL_HEAD'][] = '<link rel="manifest" href="manifest.webmanifest">';
        $this->addAppleTouchIcons();
        // register service worker
        $GLOBALS['TL_HEAD'][] = '<script>
          if (\'serviceWorker\' in navigator) {
            navigator.serviceWorker.register("./sw.js")
              .catch(err => console.log(err));
          }
        </script>';
    }
    
    /**
     * Adds the required link tags to load the apple touch icons.
     * iOS does not load icons via the manifest file yet.
     */
    public function addAppleTouchIcons()
    {
        $configId = $this->pwaConfiguration;
        $config = System::getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository(PwaConfiguration::class)
            ->findOneBy(['id' => $configId]);
        if ($config instanceof PwaConfiguration) {
            $apple120Icon = FilesModel::findByUuid($config->getAppleIcon120());
            $apple152Icon = FilesModel::findByUuid($config->getAppleIcon152());
            $apple180Icon = FilesModel::findByUuid($config->getAppleIcon180());
            $apple167Icon = FilesModel::findByUuid($config->getAppleIcon167());
            
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" href="' . $apple120Icon->path . '">';
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="152x152" href="' . $apple152Icon->path . '">';
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="180x180" href="' . $apple180Icon->path . '">';
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="167x167" href="' . $apple167Icon->path . '">';
        }
    }
    
}