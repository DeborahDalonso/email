<?php

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  [!] NOTICE
 * -----------------------------------------------------------------------------
 *
 *  If you need to make modifications to the default configuration,
 *  copy this file to your 'app/config' folder, and make them in there.
 *
 *  This will allow you to upgrade FuelPHP without losing your custom config.
 *
 */

return array(
    /**
     * -------------------------------------------------------------------------
     *  Base URL
     * -------------------------------------------------------------------------
     *
     *  The base URL of the application.
     *
     *  You can set this to a full or relative URL:
     *
     *      'base_url' => '/foo/',
     *      'base_url' => 'http://foo.com/'
     *
     *  It MUST contain a trailing slash (/).
     *
     *  Set this to null to have it automatically detected.
     *
     */

    'base_url' => null,

    /**
     * -------------------------------------------------------------------------
     *  URL Suffix
     * -------------------------------------------------------------------------
     *
     *  Any suffix that needs to be added to URL's generated by Fuel.
     *  If the suffix is an extension, make sure to include the dot.
     *
     *      'url_suffix' => '.html',
     *
     *  Set this to an empty string if no suffix is used.
     *
     */

    'url_suffix' => '',

    /**
     * -------------------------------------------------------------------------
     *  URL Rewriting
     * -------------------------------------------------------------------------
     *
     *  Set this to 'index.php' if you don't use URL rewriting.
     *
     */

    'index_file' => false,

    /**
     * -------------------------------------------------------------------------
     *  Application profiling - Settings
     * -------------------------------------------------------------------------
     */

    'profiling' => false,

    'log_profile_data' => false,

    /**
     * -------------------------------------------------------------------------
     *  Application profiling - Profiling Paths
     * -------------------------------------------------------------------------
     *
     *  The paths to be displayed in profiler.
     *
     *  If you do not wish to see the path, set this to 'null'.
     *  You can also add other paths that you wish not to see.
     *
     */

    'profiling_paths' => array(
        'APPPATH'  => APPPATH,
        'COREPATH' => COREPATH,
        'PKGPATH'  => PKGPATH,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Cache - Directory
     * -------------------------------------------------------------------------
     */

    'cache_dir' => APPPATH . 'cache' . DS,

    /**
     * -------------------------------------------------------------------------
     *  Cache - Settings
     * -------------------------------------------------------------------------
     *
     *  Settings for the file finder cache.
     *
     *  [!] WARNING:
     *
     *  The Cache class has it's own config.
     *
     */

    'caching' => false,

    /**
     * -------------------------------------------------------------------------
     *  Cache - Expirations
     * -------------------------------------------------------------------------
     *
     *  Cache expiration in seconds.
     *
     */

    'cache_lifetime' => 3600,

    /**
     * -------------------------------------------------------------------------
     *  OB Callback
     * -------------------------------------------------------------------------
     *
     *  Callback to use with ob_start(), set this to 'ob_gzhandler'
     *  for gzip encoding of output.
     *
     */

    'ob_callback' => 'ob_gzhandler',

    /**
     * -------------------------------------------------------------------------
     *  Errors
     * -------------------------------------------------------------------------
     */

    'errors' => array(
        /**
         * ---------------------------------------------------------------------
         *  Behavior
         * ---------------------------------------------------------------------
         *
         *  Which errors should we show, but continue execution? You can add
         *  the following:
         *
         *      E_NOTICE, E_WARNING, E_DEPRECATED, E_STRICT
         *
         *  to mimic PHP's default behaviour (which is to continue
         *  on non-fatal errors). We consider this bad practice.
         *
         */

        'continue_on' => array(),

        /**
         * ---------------------------------------------------------------------
         *  Throttling
         * ---------------------------------------------------------------------
         *
         *  How many errors should we show before we stop showing them?
         *
         *  [!] INFO:
         *
         *  This is useful to prevents out-of-memory errors.
         *
         */

        'throttle' => 10,

        /**
         * ---------------------------------------------------------------------
         *  Notification
         * ---------------------------------------------------------------------
         *
         *  Should notices from Error::notice() be shown?
         *
         */

        'notices' => true,

        /**
         * ---------------------------------------------------------------------
         *  Rendering
         * ---------------------------------------------------------------------
         *
         *  Render previous contents or show it as HTML?
         *
         */

        'render_prior' => false,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Language - Default
     * -------------------------------------------------------------------------
     */

    'language' => 'pt-br',

    /**
     * -------------------------------------------------------------------------
     *  Language - Fallback
     * -------------------------------------------------------------------------
     *
     *  Fallback language when file isn't available for default language.
     *
     */

    'language_fallback' => 'pt-br',

    /**
     * -------------------------------------------------------------------------
     *  Language - Locale
     * -------------------------------------------------------------------------
     *
     *  PHP set_locale() setting. Use null to not set.
     *
     */

    'locale' => false,
    'locales' => array(
        'en' => 'en',
        'pt-br' => 'pt-br',
        'es' => 'es',
    ),

    /**
     * -------------------------------------------------------------------------
     *  Language - Character Encoding
     * -------------------------------------------------------------------------
     *
     *  Internal string encoding charset.
     *
     */

    'encoding' => 'UTF-8',

    /**
     * -------------------------------------------------------------------------
     *  DateTime - GMT Offset
     * -------------------------------------------------------------------------
     *
     *  The server offset in seconds from GMT timestamp when time() is used.
     *
     */

    'server_gmt_offset' => 0,

    /**
     * -------------------------------------------------------------------------
     *  DateTime - Time Zone
     * -------------------------------------------------------------------------
     *
     *  Change the server's default timezone. This is optional.
     *
     */

    'default_timezone' => 'America/Recife',

    /**
     * -------------------------------------------------------------------------
     *  Log - Threshold
     * -------------------------------------------------------------------------
     *
     *  Can be set to any of the following:
     *
     *      Fuel::L_NONE
     *      Fuel::L_ERROR
     *      Fuel::L_WARNING
     *      Fuel::L_DEBUG
     *      Fuel::L_INFO
     *      Fuel::L_ALL
     *
     */

    'log_threshold' => \Fuel::L_WARNING,

    /**
     * -------------------------------------------------------------------------
     *  Log - Settings
     * -------------------------------------------------------------------------
     *
     *  Log file and path will be generated if the value is not provided or null
     *
     */

    'log_file' => null,
    'log_path' => APPPATH . 'logs' . DS,

    'log_date_format' => 'Y-m-d H:i:s',

    /**
     * -------------------------------------------------------------------------
     *  CLI Backtrace
     * -------------------------------------------------------------------------
     *
     *  If true, a backtrace is printed when a PHP fatal error is encountered
     *  in CLI mode.
     *
     */

    'cli_backtrace' => false,

    /**
     * -------------------------------------------------------------------------
     *  Security
     * -------------------------------------------------------------------------
     */

    'security' => array(
        /**
         * ---------------------------------------------------------------------
         *  CSRF - Autoload
         * ---------------------------------------------------------------------
         *
         *  If true, every HTTP request of the type speficied in
         *  'autoload_methods' below will be checked for a CSRF token.
         *  If not present or not valid, a security exception will be thrown.
         *
         */

        'csrf_autoload' => false,

        'csrf_autoload_methods' => array('post', 'put', 'delete'),

        /**
         * ---------------------------------------------------------------------
         *  CSRF - Error Handling
         * ---------------------------------------------------------------------
         *
         *  If true, a 'HttpBadRequestException' will be thrown.
         *  If false, a generic 'SecurityException' will be thrown.
         *
         *  It is false by default for B/C reasons.
         *
         */

        'csrf_bad_request_on_fail' => false,

        /**
         * ---------------------------------------------------------------------
         *  CSRF - Token Generation
         * ---------------------------------------------------------------------
         *
         *  If true, Form::open() adds CSRF token hidden field automatically.
         *
         */

        'csrf_auto_token' => false,

        /**
         * ---------------------------------------------------------------------
         *  CSRF - Token Key Name
         * ---------------------------------------------------------------------
         *
         *  Name of the form field that holds the CSRF token.
         *
         */

        'csrf_token_key' => 'fuel_csrf_token',

        /**
         * ---------------------------------------------------------------------
         *  CSRF - Token Expiration
         * ---------------------------------------------------------------------
         *
         *  Expiry of the token in seconds.
         *
         *  Set to 0 if you want the token remains the same for the entire
         *  user session.
         *
         */

        'csrf_expiration' => 0,

        /**
         * ---------------------------------------------------------------------
         *  CSRF - Token Rotation
         * ---------------------------------------------------------------------
         *
         *  Always rotate the CSRF token after a succesful check.
         *
         */

        'csrf_rotate' => true,

        /**
         * ---------------------------------------------------------------------
         *  Salt
         * ---------------------------------------------------------------------
         *
         *  Salt to make sure the generated security tokens aren't predictable.
         *
         */

        'token_salt' => 'put your salt value here to make the token more secure',

        /**
         * ---------------------------------------------------------------------
         *  X-Headers
         * ---------------------------------------------------------------------
         *
         *  Allow the Input class to use X headers when present.
         *
         *  Examples of these are:
         *
         *      HTTP_X_FORWARDED_FOR and HTTP_X_FORWARDED_PROTO
         *
         *  which can be faked which could have security implications.
         *
         */

        'allow_x_headers' => false,

        /**
         * ---------------------------------------------------------------------
         *  Filters
         * ---------------------------------------------------------------------
         *
         *  These input filter can be any normal PHP function
         *  as well as 'xss_clean'.
         *
         *  [!] WARNING:
         *
         *  Using 'xss_clean' will cause a performance hit. How much it would
         *  is depending on how much the input data.
         *
         *  These MUST be defined in the 'application/config' file.
         *
         */

        // 'uri_filter' => array('htmlentities'),

        // 'input_filter' => array(),

        'output_filter' => array('Security::htmlentities'),

        /**
         * ---------------------------------------------------------------------
         *  HTML Entities - Encoding Mode
         * ---------------------------------------------------------------------
         *
         *  Encoding mechanism to use on htmlentities().
         *
         */

        'htmlentities_flags' => ENT_QUOTES,

        /**
         * ---------------------------------------------------------------------
         *  HTML Entities - Encoding Method
         * ---------------------------------------------------------------------
         *
         *  Whether to encode HTML entities as well.
         *
         */

        'htmlentities_double_encode' => false,

        /**
         * ---------------------------------------------------------------------
         *  HTML Entities - Auto Filter
         * ---------------------------------------------------------------------
         *
         *  Whether to automatically filter view data.
         *
         */

        'auto_filter_output' => true,

        /**
         * ---------------------------------------------------------------------
         *  Closures
         * ---------------------------------------------------------------------
         *
         *  Whether to filter closures as well.
         *
         */

        'filter_closures' => true,

        /**
         * ---------------------------------------------------------------------
         *  Class Whitelist
         * ---------------------------------------------------------------------
         *
         *  With output encoding switched on, all objects passed will be
         *  converted to strings or throw exceptions unless they are instances
         *  of the classes in this array.
         *
         */

        'whitelisted_classes' => array(
            'Fuel\\Core\\Presenter',
            'Fuel\\Core\\Response',
            'Fuel\\Core\\View',
            'Fuel\\Core\\ViewModel',
            'Closure'
        ),

        /**
         * ---------------------------------------------------------------------
         *  Form - URL Encoding
         * ---------------------------------------------------------------------
         *
         *  Set this to true if your client sends data using these HTTP methods:
         *
         *      PUT, DELETE or PATCH
         *
         *  and using the 'www-form-urlencoded' content type and its content is
         *  urlencoded locally before submitted.
         *
         */

        'form-double-urlencoded' => false,

        /**
         * ---------------------------------------------------------------------
         *  Path Cleaning
         * ---------------------------------------------------------------------
         *
         *  Paths to clean before outputting FQFN or paths.
         *
         *  If you do not wish to see the path, set this to 'null'.
         *  You can also add other paths that you wish not to see.
         *
         */

        'clean_paths' => array(),
    ),

    /**
     * -------------------------------------------------------------------------
     *  Cookie
     * -------------------------------------------------------------------------
     */

    'cookie' => array(
        /**
         * ---------------------------------------------------------------------
         *  Expiration
         * ---------------------------------------------------------------------
         *
         *  Number of seconds before the cookie expires.
         *
         */

        'expiration' => 0,

        /**
         * ---------------------------------------------------------------------
         *  Path
         * ---------------------------------------------------------------------
         *
         *  Restrict the path that the cookie is available to.
         *
         */

        'path' => '/',

        /**
         * ---------------------------------------------------------------------
         *  Domain
         * ---------------------------------------------------------------------
         *
         *  Restrict the domain that the cookie is available to.
         *
         */

        'domain' => null,

        /**
         * ---------------------------------------------------------------------
         *  Security - Status
         * ---------------------------------------------------------------------
         *
         *  Only transmit cookies over secure connections.
         *
         */

        'secure' => false,

        /**
         * ---------------------------------------------------------------------
         *  Security - Mode
         * ---------------------------------------------------------------------
         *
         *  Only transmit cookies over HTTP, disabling JavaScript access.
         *
         */

        'http_only' => false,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Validation
     * -------------------------------------------------------------------------
     */

    'validation' => array(
        /**
         * ---------------------------------------------------------------------
         *  Compatibility
         * ---------------------------------------------------------------------
         *
         *  Whether falling back to global when a value is not found
         *  in input array.
         *
         */

        'global_input_fallback' => true,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Controller Class Prefix
     * -------------------------------------------------------------------------
     */

    'controller_prefix' => 'Controller\\',

    /**
     * -------------------------------------------------------------------------
     *  Routing
     * -------------------------------------------------------------------------
     */

    'routing' => array(
        /**
         * ---------------------------------------------------------------------
         *  Compatibility
         * ---------------------------------------------------------------------
         *
         *  Whether URI routing is case sensitive or not.
         *
         */

        'case_sensitive' => true,

        /**
         * ---------------------------------------------------------------------
         *  Compatibility - Extension
         * ---------------------------------------------------------------------
         *
         *  Whether to strip the extension or not.
         *
         *  You can provide an array with a list of extensions to be stripped.
         *
         *      'strip_extension' => array('.html', '.php')
         *
         */

        'strip_extension' => true,

        /**
         * ---------------------------------------------------------------------
         *  Module
         * ---------------------------------------------------------------------
         *
         *  Whether module routes should be loaded when loading a module.
         *
         */

        'module_routes' => false,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Response
     * -------------------------------------------------------------------------
     */

    'response' => array(
        /**
         * ---------------------------------------------------------------------
         *  Compatibility
         * ---------------------------------------------------------------------
         *
         *  Whether to support URI wildcards when redirecting.
         *
         */

        'redirect_with_wildcards' => true,
    ),

    /**
     * -------------------------------------------------------------------------
     *  Configurations
     * -------------------------------------------------------------------------
     */

    'config' => array(
        /**
         * ---------------------------------------------------------------------
         *  Database
         * ---------------------------------------------------------------------
         *
         *  Database that holds the config table.
         *
         */

        'database' => null,

        /**
         * ---------------------------------------------------------------------
         *  Database - Table Name
         * ---------------------------------------------------------------------
         *
         *  Name of the table used by the Config_Db driver.
         *
         */

        'table_name' => 'config',

        /**
         * ---------------------------------------------------------------------
         *  Memcached
         * ---------------------------------------------------------------------
         *
         *  Servers and port numbers that run the memcached service
         *  for config data.
         *
         */

        'memcached'    => array(
            'identifier' => 'config',

            'servers' => array(
                array(
                    'host'   => '127.0.0.1',
                    'port'   => 11211,
                    'weight' => 100
                ),
            ),
        ),
    ),

    /**
     * -------------------------------------------------------------------------
     *  Language
     * -------------------------------------------------------------------------
     */

    'lang' => array(
        /*
		 * Database that holds the lang table
		 */
        'database' => null,

        /*
		 * Name of the table used by the Lang_Db driver
		 */
        'table_name' => 'lang',
    ),

    /**
     * -------------------------------------------------------------------------
     *  Module paths
     * -------------------------------------------------------------------------
     *
     *  To enable you to split up your application into modules which can be
     *  routed by the first uri segment you have to define their basepaths here.
     *  By default is empty, but to use them you can add something like this:
     *
     *      'module_paths' => array(APPPATH.'modules'.DS)
     *
     *  Paths MUST end with a directory separator (the DS constant)!
     *
     */

    'module_paths' => array(
        APPPATH.'modules'.DS
    ),

    /**
     * -------------------------------------------------------------------------
     *  Package paths
     * -------------------------------------------------------------------------
     *
     *  To enable you to split up your additions to the framework, packages are
     *  used. You can define the basepaths for your packages here. By default is
     *  empty, but to use them you can add something like this:
     *
     *      'package_paths' => array(APPPATH.'modules'.DS)
     *
     *  Paths MUST end with a directory separator (the DS constant)!
     *
     */

    'package_paths' => array(
        PKGPATH
    ),

    /**
     * -------------------------------------------------------------------------
     *  Always load
     * -------------------------------------------------------------------------
     */

    'always_load' => array(
        /**
         * ---------------------------------------------------------------------
         *  Packages
         * ---------------------------------------------------------------------
         *
         *  These packages are loaded on Fuel's startup.
         *  You can specify them in the following manner:
         *
         *      'packages' => array('auth');
         *
         *  This will assume the packages are in PKGPATH.
         *
         *  Use this format to specify the path to the package explicitly.
         *
         *      'packages' => array(
         *          array('auth' => PKGPATH.'auth/')
         *      );
         *
         */

        'packages' => array(
            'orm',
            'auth',
        ),

        /**
         * ---------------------------------------------------------------------
         *  Modules
         * ---------------------------------------------------------------------
         *
         *  These modules are always loaded on Fuel's startup.
         *  You can specify them in the following manner:
         *
         *      'modules' => array('module_name');
         *
         *  A path must be set in 'module_paths' for this to work.
         *
         */

        'modules' => array('admin'),

        /**
         * ---------------------------------------------------------------------
         *  Classes
         * ---------------------------------------------------------------------
         *
         *  Classes to autoload & initialize even when not used.
         *
         */

        'classes' => array(),

        /**
         * ---------------------------------------------------------------------
         *  Configurations
         * ---------------------------------------------------------------------
         *
         *  Configurations to autoload
         *
         *  If you want to load 'session' config into a group 'session',
         *  you only have to add 'session'.
         *
         *      'config' => array('session')
         *
         *  If you want to add it to another group (example: 'auth'),
         *  you have to add it like:
         *
         *      'config' => array('session' => 'auth')
         *
         *  If you don't want the config in a group, use null as groupname.
         *
         */

        'config' => array(),

        /**
         * ---------------------------------------------------------------------
         *  Languages
         * ---------------------------------------------------------------------
         *
         *  Language files to autoload
         *
         *  If you want to load 'validation' lang into a group 'validation',
         *  you only have to add 'validation'.
         *
         *      'language' => array('validation')
         *
         *  If you want to add it to another group (example: 'forms'),
         *  you have to add it like:
         *
         *      'language' => array('validation' => 'forms')
         *
         *  If you don't want the lang in a group, use null as groupname.
         *
         */

        'language' => array(),
    ),
);
