## ZooApp Backend
**Demo**: [zoo.dguaycha.com](https://zoo.dguaycha.com)
### Requerimientos

* Php 7.4+
* Composer
* MySQL

### Instalación

1. Descargar las librerías 

    ````bash
    composer install
    ````

2. Configurar variables de entorno

   ````bas
   cp .env-example .env
   ````

   ````yam
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=zoo_backend
   DB_USERNAME=root
   DB_PASSWORD=password
   ````

3. Generar una key

   ````bas
   php artisan key:generate
   ````

4. Ejecutar las migraciones

   ````bas
   php artisan migrate --seed
   ````

### Iniciar el servidor de prueba

````bas
php artisan serve
````

