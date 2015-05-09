<?php
/**
 * Created by PhpStorm.
 * User: framato
 * Date: 30/11/14
 * Time: 21:11
 */

namespace Whopa\Ldapsearch;

use Illuminate\Config\Repository;

class Ldapsearch {

    protected $connection;
    protected $config;
    protected $adminUser;
    protected $adminPass;
    protected $basedn;

    public function __construct(Repository $config)
    {
        # Config
        $this->config = $config;

        # Admin
        $this->adminUser = $this->config->get('ldapsearch::admin_user');
        $this->adminPass = $this->config->get('ldapsearch::admin_pass');

        # BaseDN
        $this->basedn = $this->config->get('ldapsearch::basedn');

        # Conectar
        $this->connection = $this->_connect();
    }

    /**
     * Conectar a servidor LDAP
     *
     * @return resource
     * @throws \Exception
     */
    protected function _connect()
    {
        $server = $this->config->get('ldapsearch::server');
        $port = $this->config->get('ldapsearch::port');

        $cnn = @ldap_connect($server, $port);
        ldap_set_option($cnn, LDAP_OPT_PROTOCOL_VERSION, $this->config->get('ldapsearch::protocol_version'));
        ldap_set_option($cnn, LDAP_OPT_REFERRALS, 0);

        if (!$cnn) throw new \Exception('Error en la conexión con el servidor LDAP');

        return $cnn;
    }

    /**
     * BIND de usuario y contraseña
     *
     * @param $username
     * @param $password
     * @return bool
     */
    protected function _bind($username, $password)
    {
        $anonimo = $this->config->get('ldapsearch::anonimo', false);

        if (!$anonimo)
        {
            if ($username == '' || $password == '')
                return false;
        }

        $user = $username . '@' . $this->config->get('ldapsearch::domain');
        $res = @ldap_bind($this->connection, $user, $password);

        return $res;
    }

    /**
     * Genera array con los datos extraídos de LDAP
     *
     * @param $items
     * @return array
     */
    protected function _generateArray($items)
    {
        $arrItems = [];
        $atributos = $this->config->get('ldapsearch::attributes');

        $entry = ldap_first_entry($this->connection, $items);

        # Si no hay resultado, devuelvo vacío
        if (!$entry)
            return $arrItems;

        do {
            $attrs = ldap_get_attributes($this->connection, $entry);
            $items = [];

            foreach ($atributos as $attr)
            {
                $items["$attr"] = (array_search($attr, $attrs) != false) ? $attrs["$attr"][0] : null;
            }

            array_push($arrItems, $items);

        } while ($entry = ldap_next_entry($this->connection, $entry));

        return $arrItems;
    }

    /**
     * Buscar según criterios especificados
     *
     * @param $filter
     * @return array
     */
    protected function _search($filter)
    {
        # Autentifico con claves de admin
        $this->_bind($this->adminUser, $this->adminPass);

        $res = ldap_search($this->connection, $this->basedn, $filter);

        return $this->_generateArray($res);
    }

    protected function _updateData($userdn, $entry = [])
    {
        if (ldap_modify($this->connection, $userdn, $entry))
            return true;
        else
            return false;
    }

    protected function _getUserDN($username)
    {
        $filter = '(sAMAccountName=' . $username . ')';
        $userSearch = ldap_search($this->connection, $this->basedn, $filter);
        $userEntry = ldap_first_entry($this->connection, $userSearch);
        $userDn = ldap_get_dn($this->connection, $userEntry);

        return $userDn;
    }

    /**
     * Autentificar usuario
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function auth($username, $password)
    {
        $res = $this->_bind($username, $password);

        return $res;
    }

    /**
     * Búsqueda por nombre de usuario
     *
     * @param $username
     * @return array
     */
    public function searchByUsername($username)
    {
        # Filtro
        $filter = '(sAMAccountName=' . $username . ')';

        $res = $this->_search($filter);

        return $res;
    }

    /**
     * Búsqueda por nombre completo
     *
     * @param $fullname
     * @return array
     */
    public function searchByFullname($fullname)
    {
        # Filtro
        $filter = '(cn=' . $fullname . ')';

        return $this->_search($filter);
    }

    /**
     * Búsqueda con valores personalizados
     *
     * @param $parameter
     * @param $search
     * @return array
     */
    public function customSearch($parameter, $search)
    {
        # Filtro
        $filter = "($parameter=$search)";

        return $this->_search($filter);
    }

    public function changePassword($username, $oldPassword, $newPassword)
    {
        $this->_bind($username, $oldPassword);
        $userDN = $this->_getUserDN($username);

        $newpass = '{SHA}' . base64_encode(pack('H*', sha1($newPassword)));
        $entry = [
            'userPassword' => $newpass
        ];

        $resultado = $this->_updateData($userDN, $entry);

        return $resultado;
    }


} 