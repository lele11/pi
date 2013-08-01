<?php
return array(
    'item'  => array(
        'front'     => false,
        'admin'     => array(
            'token'     => array(
                'label'         => 'Token Manager',
                'route'         => 'admin',
                'controller'    => 'index',
                'action'        => 'index',
                'resource'      => array(
                    'resource'  => 'script',
                ),
            ),
        ),
    ),
);
