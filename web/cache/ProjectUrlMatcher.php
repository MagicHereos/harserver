<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * ProjectUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);

        if (0 === strpos($pathinfo, '/citizen')) {
            // citizen_profile
            if (0 === strpos($pathinfo, '/citizen/profile') && preg_match('#^/citizen/profile/(?P<id>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'citizen_profile')), array (  '_controller' => 'CitizenController::profile',  'page' => 1,));
            }

            // citizen_search
            if (0 === strpos($pathinfo, '/citizen/search') && preg_match('#^/citizen/search/(?P<query>[^/]++)/(?P<page>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'citizen_search')), array (  '_controller' => 'CitizenController::search',  'page' => 1,));
            }

        }

        if (0 === strpos($pathinfo, '/battle')) {
            // battle_active
            if (0 === strpos($pathinfo, '/battle/active') && preg_match('#^/battle/active\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'battle_active')), array (  '_controller' => 'BattleController::active',));
            }

            // battle
            if (preg_match('#^/battle/(?P<id>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'battle')), array (  '_controller' => 'BattleController::battle',));
            }

        }

        if (0 === strpos($pathinfo, '/country')) {
            // country_society
            if (preg_match('#^/country/(?P<code>[^/]++)/society\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'country_society')), array (  '_controller' => 'CountryController::society',));
            }

            // country_economy
            if (preg_match('#^/country/(?P<code>[^/]++)/economy\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'country_economy')), array (  '_controller' => 'CountryController::economy',));
            }

        }

        // exchange
        if (0 === strpos($pathinfo, '/exchange') && preg_match('#^/exchange/(?P<mode>[^/]++)/(?P<page>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'exchange')), array (  '_controller' => 'ExchangeController::get',  'page' => 1,));
        }

        // jobmarket
        if (0 === strpos($pathinfo, '/jobmarket') && preg_match('#^/jobmarket/(?P<code>[^/]++)/(?P<page>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'jobmarket')), array (  '_controller' => 'JobMarketController::get',  'page' => 1,));
        }

        // market
        if (0 === strpos($pathinfo, '/market') && preg_match('#^/market/(?P<country>[^/]++)/(?P<industry>[^/]++)/(?P<quality>[^/]++)/(?P<page>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'market')), array (  '_controller' => 'MarketController::get',  'page' => 1,  'quality' => 1,));
        }

        if (0 === strpos($pathinfo, '/unit')) {
            // unit
            if (preg_match('#^/unit/(?P<unit>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'unit')), array (  '_controller' => 'MUController::get',));
            }

            // regiment
            if (preg_match('#^/unit/(?P<unit>[^/]++)/(?P<regiment>[^/\\.]++)\\.(?P<_format>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'regiment')), array (  '_controller' => 'MUController::getRegiment',));
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
