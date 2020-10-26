<?php

class Spinsch_Ngrok_Helper_Data
{
    /**
     * @var string
     */
    protected $_host = null;

    /**
     * Get ngrok host
     *
     * @return mixed
     */
    public function getHost()
    {
        if ($this->_host === null) {

            $host = $this->getServerParam('HTTP_X_ORIGINAL_HOST');

            if (empty($host)) {
                $host = $this->getServerParam('HTTP_HOST');
            }

            $this->_host = (stripos($host, '.ngrok.io') !== false) ? $host : false;
        }

        return $this->_host;
    }

    /**
     * Is ngrok request
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getHost();
    }

    /**
     * Get protocol
     *
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->getServerParam('HTTP_X_FORWARDED_PROTO');
    }

    /**
     * Is secure request
     *
     * @return bool
     */
    public function isSecure()
    {
        return ($this->getProtocol() == 'https');
    }

    /**
     * Get server param by key
     *
     * @param $key
     * @return mixed
     */
    public function getServerParam($key)
    {
        return Mage::app()->getRequest()->getServer($key);
    }
}