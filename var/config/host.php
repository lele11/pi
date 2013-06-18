<?php
/**
 * Pi Engine host specifications
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Copyright (c) Pi Engine http://www.xoopsengine.org
 * @license         http://www.xoopsengine.org/license New BSD License
 * @author          Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 * @version         $Id$
 */

//Host definition file
//Paths/URLs to system folders
//URIs without a leading slash are considered relative to the current Pi Engine host location
//URIs with a leading slash are considered semi-relative (you must setup proper rewriting rules in your server conf)

return array(
    // URIs to resources
    // If URI is a relative one then www root URI will be prepended
    'uri'       => array(
        // WWW root URI
        'www'       => 'http://pi-oauth.com',
        // URI to access uploads directory
        'upload'    => 'http://pi-oauth.com/upload',
        // URI to access assets directory
        'asset'     => 'http://pi-oauth.com/asset',
        // URI to access static files directory
        'static'    => 'http://pi-oauth.com/static',
    ),

    // Paths to resources
    // If path is a relative one then www root path will be prepended
    'path'      => array(
        // WWW root path
        'www'       => '/var/www/html/pi/www',
        // Library directory
        'lib'       => '/var/www/html/pi/lib',
        // User extension directory
        'usr'       => '/var/www/html/pi/usr',
        // User data directory
        'var'       => '/var/www/html/pi/var',
        // Application module directory
        'module'    => '/var/www/html/pi/usr/module',
        // Theme directory
        'theme'     => '/var/www/html/pi/usr/theme',

        // Path to uploads directory
        'upload'    => '/var/www/html/pi/www/upload',
        // Path to assets directory
        'asset'     => '/var/www/html/pi/www/asset',
        // Path to static files directory
        'static'    => '/var/www/html/pi/www/static',

        // Path to vendor library directory
        // Optional, default as lib/vendor
        'vendor'    => '/var/www/html/pi/lib/vendor',

        // Dependent paths
        // Note: optional, will be located in var if not specified
        // Path to global configuration directory
        'config'    => '/var/www/html/pi/var/config',
        // Path to cache files directory
        'cache'     => '/var/www/html/pi/var/cache',
        // Path to logs directory
        'log'       => '/var/www/html/pi/var/log',
    )
);
