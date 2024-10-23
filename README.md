# REST API TDD

# Instalación de Dependencias

# Composer

1.- Para instalar las dependencias de PHP, ejecuta el siguiente comando:
    composer install

2.- Configuración del Archivo de Entorno
    Renombra el archivo .env.example a .env:
    cp .env.example .env

    -Luego, abre el archivo .env y actualiza las variables de entorno, especialmente la configuración de la base de datos:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=TDD
        DB_USERNAME=usuario_bd
        DB_PASSWORD=contraseña_bd

# Generar una Clave de Aplicación

3.- Para generar una clave de aplicación, ejecuta el siguiente comando:
    php artisan key:generate

# Creacion de la Base de Datos

4.- Para crear la base de datos, ejecuta el siguiente comando:
    php artisan migrate --seed

# Correr los test

5.- Para correr los test, ejecuta el siguiente comando:
    php artisan test
