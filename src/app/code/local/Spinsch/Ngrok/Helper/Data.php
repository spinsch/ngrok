<?php

class Spinsch_Ngrok_Helper_Data
{
    /**
     * @var mixed
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

            // it need to overwrite http_host for special calls
            // especially for api calls with WSDL

            if (isset($_SERVER['HTTP_X_ORIGINAL_HOST'])) {
                $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_ORIGINAL_HOST'];
            }

            if (stripos($_SERVER['HTTP_HOST'], '.ngrok.io') !== false) {
                $this->_host = $_SERVER['HTTP_HOST'];
            } else {
                $this->_host = false;
            }
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
        return $_SERVER['HTTP_X_FORWARDED_PROTO'];
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
}