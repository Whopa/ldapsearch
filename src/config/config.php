<?php

return [
    /**
     * Servidor LDAP
     */
    'server' => '',

    /**
     * Puerto para conectar al servidor LDAP
     */
    'port' => '389',

    /**
     * Dominio
     */
    'domain' => 'whopa.net',

    /**
     * Base DN
     */
    'basedn' => 'dc=whopa,dc=net',

    /**
     * Versión del Protocolo
     */
    'protocol_version' => 3,

    /**
     * Nombre de usuario del administrador LDAP
     */
    'admin_user' => '',

    /**
     * Contraseña del administrador de LDAP
     */
    'admin_pass' => '',

    /**
     * Permitir loguear con usuario anónimo
     */
    'anonimo' => false,

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