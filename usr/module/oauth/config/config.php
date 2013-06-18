<?php
return $config = array(
    'server'    => array(
        'authorization' => array(
            'response_types'    => array(
                'code', 'token',
            ),
        ),
        'grant' => array(
            'grant_types'   => array(
                'authorization_code'    => 'AuthorizationCode',
                'password'              => 'Password',
                'client_credentials'    => 'ClientCredentials',
                'refresh_token'         => 'RefreshToken',
                'urn:ietf:params:oauth:grant-type:jwt-bearer'
                                        => 'JwtBearer',
            ),
        ),
        'resource'  => array(
            'token_type'    => 'bearer',
            'www_realm'     => 'service',
        ),
    ),
    'storage'   => array(
        'model_set'             => array(
            'name'      => 'database',
            'config'    => array(
                'table_prefix'  => 'oauth',
            ),
        ),
        'authorization_code'    => array(
            'expires_in'    => 30,
            'length'        => 40,
        ),
        'access_token'  => array(
            'token_type'    => 'bearer',
            'expires_in'    => 3600,
            'length'        => 40,
        ),
        'refresh_token' => array(
            'expires_in'    => 1209600,
            'length'        => 40,
        ),
    ),
);