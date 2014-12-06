# LDAP Search

Paquete de Laravel para realizar búsqueda y autenticación en Active Directory.

### Instalación
Para instalar este paquete, agregar lo siguiente en el archivo composer.json

```sh
require {
    "whopa/ldapsearch": "1.0.*"
}
```

Correr, `composer install` ó `composer update`

Abrir `config/app.php` y agregar lo siguiente `Whopa\Ldapsearch\LdapsearchServiceProvider`

Correr el siguiente comando `php artisan config:publish whopa/ldapsearch`

###Configuración

Abrir `àpp/config/packages/whopa/ldapsearch/config.php` y completar los parámetros con los del servidor al que se quiera conectar.

###Uso

Para buscar por nombre de usuario
```sh
$user = Ldapsearch::searchByUsername($username);
```

Para buscar por nombre completo
```sh
$user = Ldapsearch::searchByFullname($fullname);
```

Para realizar una búsqueda personalizada.
```sh
$resultado = Ldapsearch::customSearch($parameter, $search);
```

Autentificación. Devuelve TRUE o FALSE
```sh
if (Ldapsearch::auth($username, $password))
{
    # True
} else {
    # False
}
```


