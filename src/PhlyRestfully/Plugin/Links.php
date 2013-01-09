<?php

namespace PhlyRestfully\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\Plugin\Url as UrlHelper;
use Zend\View\Helper\ServerUrl as ServerUrlHelper;

/**
 * Plugin for generating fully qualified links, and sets of HAL-compliant 
 * link relations
 *
 * @see http://tools.ietf.org/html/draft-kelly-json-hal-03
 */
class Links extends AbstractPlugin
{
    /**
     * @var ServerUrlHelper
     */
    protected $serverUrlHelper;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * @param ServerUrlHelper $helper 
     */
    public function setServerUrlHelper(ServerUrlHelper $helper)
    {
        $this->serverUrlHelper = $helper;
    }

    /**
     * @param UrlHelper $helper 
     */
    public function setUrlHelper(UrlHelper $helper)
    {
        $this->urlHelper = $helper;
    }

    /**
     * Create a fully qualified URI for a link
     * 
     * @param  string $route 
     * @param  null|int|string $id 
     * @return string
     */
    public function createLink($route, $id = null)
    {
        $params = array();
        if (null !== $id) {
            $params['id'] = $id;
        }

        $path = $this->urlHelper->fromRoute($route, $params);
        return $this->serverUrlHelper->__invoke($path);
    }

    /**
     * Generate HAL link relation list
     * 
     * @param  array $links 
     * @return array
     */
    public function generateHalLinkRelations(array $links)
    {
        $halLinks = array();
        foreach ($links as $rel => $link) {
            $halLinks[$rel] = array('href' => $link);
        }
        return $halLinks;
    }
}
