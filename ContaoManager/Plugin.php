<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    7
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\PwaBundle\ContaoManager;

use con4gis\CoreBundle\con4gisCoreBundle;
use con4gis\PwaBundle\con4gisPwaBundle;
use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Config\ConfigInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use Minishlink\Bundle\WebPushBundle\MinishlinkWebPushBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollection;

class Plugin implements BundlePluginInterface, ConfigPluginInterface, RoutingPluginInterface
{
    /**
     * Gets a list of autoload configurations for this bundle.
     *
     * @param ParserInterface $parser
     *
     * @return ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(MinishlinkWebPushBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
            BundleConfig::create(con4gisPwaBundle::class)
                ->setLoadAfter([
                    con4gisCoreBundle::class,
                    MinishlinkWebPushBundle::class,
                    ContaoCalendarBundle::class,
                    ContaoNewsBundle::class
                ])
        ];
    }
    
    /**
     * Allows a plugin to load container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@con4gisPwaBundle/Resources/config/config.yml');
    }
    
    /**
     * Returns a collection of routes for this bundle.
     *
     * @return RouteCollection|null
     */
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__.'/../Resources/config/routing.yml')
            ->load(__DIR__.'/../Resources/config/routing.yml')
            ;
    }
}