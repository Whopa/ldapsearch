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

Abrir `config/app.php` y agregar lo siguiente `Whopa/Ldapsearch/LdapsearchServiceProvider`

Correr el siguiente comando `php artisan config:publish whopa/ldapsearch`

###Configuración