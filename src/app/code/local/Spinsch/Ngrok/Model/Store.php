<?php

class Spinsch_Ngrok_Model_Store extends Mage_Core_Model_Store
{
    /**
     * Reconfigure on ngrok request
     */
    protected function _construct()
    {
        $helper = Mage::helper('ngrok');

        if ($helper->isActive()) {
            $this->_configCache = array(
                'web/url/redirect_to_base' => 0,
                'web/cookie/cookie_domain' => $helper->getHost(),
                'web/secure/use_in_frontend' => (int)$helper->isSecure(),
                'web/secure/use_in_adminhtml' => (int)$helper->isSecure()
            );
        }

        parent::_construct();
    }

    /**
     * Replace host and scheme on ngrok request
     *
     * @param string $type
     * @param null $secure
     *
     * @return string|string[]
     * @throws Mage_Core_Exception
     */
    public function getBaseUrl($type = self::URL_TYPE_LINK, $secure = null)
    {
        $helper = Mage::helper('ngrok');
        $url = parent::getBaseUrl($type, $secure);

        // fallback for dynamic url
        if ($helper->isActive() && strpos($url, $helper->getHost()) === false) {

            $host = parse_url($url, PHP_URL_HOST);

            $search = ($helper->isSecure()) ? array($host, 'http:') : array($host, 'https:');
            $replace = ($helper->isSecure()) ? array($helper->getHost(), 'https:') : array($helper->getHost(), 'http:');

            // use own cache key
            $cacheKey = $type . '/' . (is_null($secure) ? 'null' : ($secure ? 'true' : 'false'));
            $url = $this->_baseUrlCache[$cacheKey] = str_replace($search, $replace, $url);
        }

        return $url;
    }
}

