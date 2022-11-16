<?php

return array(
    'defaults' => array(
        
        'charset' => 'UTF-8',
        'wordwrap' => 76,
        /**
         * SMTP settings
         */
        'timeout' => 5, // this can be whatever you want
        'user_name' => '',
        'host' => 'smtp-mail.outlook.com',
        'password' => '',
        'port' => '587',
        'is_html' => true,
        'security' => 'tls',
        'smtp_auth' => true
    )
);
