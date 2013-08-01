<?php
return array(
    'item'  => array(
        'front'     => false,
        'admin'     => array(
            'client'     => array(
                'label'         => '填写注册信息',
                'route'         => 'admin',
                'controller'    => 'client',
                'action'        => 'index',
            ),

            'list'       => array(
                'label'         => '查看信息列表',
                'route'         => 'admin',
                'controller'    => 'client',
                'action'        => 'list',    
            ),
            'token'      => array(
                'label'         => '授权管理',
                'route'         => 'admin',
                'controller'    => 'client',
                'action'        => 'token',
            ),
        ),
    ),
);
