<?php

return [
    /**
     * Servidor LDAP
     */
    'server' => env('LDAPS_SERVER', ''),

    /**
     * Puerto para conectar al servidor LDAP
     */
    'port' => env('LDAPS_PORT', '389'),

    /**
     * Dominio
     */
    'domain' => env('LDAPS_DOMAIN', ''),

    /**
     * Base DN
     */
    'basedn' => env('LDAPS_BASEDN', ''),

    /**
     * Versión del Protocolo
     */
    'protocol_version' => env('LDAPS_VERSION', 3),

    /**
     * Nombre de usuario del administrador LDAP
     */
    'admin_user' => env('LDAPS_ADMIN_USER', ''),

    /**
     * Contraseña del administrador de LDAP
     */
    'admin_pass' => env('LDAPS_ADMIN_PASS', ''),

    /**
     * Permitir loguear con usuario anónimo
     */
    'anonimo' => env('LDAPS_ANONIMO', false),

    /**
     * Atributos que se desea obtener de las búsquedas
     */
    'attributes' => [
        'cn',
        'displayname',
        'mail',
        'sAMAccountName',
        'givenName',
        'sn'
    ],
];