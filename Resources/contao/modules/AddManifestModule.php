<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 20.03.19
 * Time: 16:45
 */

namespace con4gis\PwaBundle\Resources\contao\modules;


use Contao\Module;

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
        // register service worker
        $GLOBALS['TL_HEAD'][] = '<script>
          if (\'serviceWorker\' in navigator) {
            navigator.serviceWorker.register("./sw.js")
              .catch(err => console.log(err));
          }
        </script>';
    }
    
}