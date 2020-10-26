# OpenMage Ngrok

Ngrok helper for OpenMage.

## Features

- Allow randomized or customized subdomains from ngrok service (.ngrok.io)
- Automatic detection for ngrok requests
- Caching prefix (No need to clear cache)
- Domain cookie for each host
- Automatic sanitize base url protocol (http/https)

## Requirements

- OpenMage LTS 19.4.x
- Ngrok 2

To support caching prefixes you have to modify the file index.php:
```php
// replace this line

Mage::run($mageRunCode, $mageRunType);

// with this lines

$options = isset($options) ? $options : array();
Mage::run($mageRunCode, $mageRunType, $options);
```

## Usage

Module itself does not require any configuration, it checks for request domain and activated only if it's .ngrok.io. So it works only when it needed for ngrok secure tunnels.