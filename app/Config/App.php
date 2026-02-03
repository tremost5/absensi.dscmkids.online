<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base URL
     */
    public $baseURL = 'https://absensi.dscmkids.online/';

    /**
     * Allowed hostnames (WAJIB CI4 >= 4.4)
     */
    public $allowedHostnames = [];

    /**
     * Index file
     */
    public $indexPage = '';

    /**
     * URI protocol
     */
    public $uriProtocol = 'REQUEST_URI';

    /**
     * URL characters
     */
    public $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * Locale
     */
    public $defaultLocale = 'id';
    public $negotiateLocale = false;
    public $supportedLocales = ['id'];

    /**
     * Timezone
     */
    public $appTimezone = 'Asia/Jakarta';

    /**
     * Charset
     */
    public $charset = 'UTF-8';

    /**
     * Force HTTPS
     */
    public $forceGlobalSecureRequests = true;

    /**
     * Reverse proxy IPs (WAJIB CI4 4.6+)
     */
    public $proxyIPs = [];

    /**
     * Content Security Policy
     */
    public $CSPEnabled = false;
    
    public $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';
    public $sessionSavePath = WRITEPATH . 'session';

}
