<?php
return array(
    // Module meta
    'meta'  => array(
        // Module title, required
        'title'         => 'OAuth Consumer',
        // Description, for admin, optional
        'description'   => __('OAuth Consumer Module for OAuth Module'),
        // Version number, required
        'version'       => '1.0',
        // Distribution license, required
        'license'       => 'New BSD',
        // Logo image, for admin, optional
        'logo'          => 'image/logo.png',
        // Readme file, for admin, optional
        'readme'        => 'docs/readme.txt',
        // Direct download link, available for wget, optional
        //'download'      => 'http://dl.xoopsengine.org/core',
        // Demo site link, optional
        // 'demo'          => 'http://demo.xoopsengine.org/demo',

        // Module is ready for clone? Default as false
        'clonable'      => false,
    ),
    // Author information
    'author'    => array(
        // Author full name, required
        'name'      => 'lele',
        // Email address, optional
        'email'     => 'lele@eefocus.com',
        // Website link, optional
        'website'   => 'http://www.xoopsengine.org',
        // Credits and aknowledgement, optional
        'credits'   => 'Pi Engine Team; Zend Framework Team; EEFOCUS Team.'
    ),
    // Maintenance actions
    'maintenance'   => array(
        // resource
        'resource' => array(
            // Database meta
            'database'  => array(
                // SQL schema/data file
                'sqlfile'   => 'sql/mysql.sql',
                'schema'    => array(
                    'oauth_clientID'   => 'table',
                )
            ),
        'config'    => 'config.php',
        // ACL specs
        'acl'       => 'acl.php',
        // Block definition
        'block'     => 'block.php',
        // Event specs
        'event'     => 'event.php',
        // View pages
        'page'      => 'page.php',
        // Navigation definition
        'navigation'    => 'navigation.php',
        // Routes, first in last out; bigger priority earlier out
        'route'     => 'route.php',
        )
    )
);
