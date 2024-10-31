# Guía de Instalación del Proyecto

## Requisitos de Servidor

Para ejecutar Laravel 10 sin problemas, asegúrate de que tu servidor cumpla con los siguientes requisitos:

- **PHP**: Versión 8.1 o superior
- **Servidor Web**: Apache
- **Composer**: Versión 2.7.9 o superior
- **Extensiones de PHP necesarias**:
  - `extension=zip`
  - `extension=fileinfo`

## Instalación de Dependencias

1. Para instalar las dependencias de PHP, ejecuta el siguiente comando:

    ```bash
    composer install
    ```

## Configuración del Archivo de Entorno

2. Renombra el archivo `.env.example` a `.env`:

    ```bash
    cp .env.example .env
    ```

3. Luego, abre el archivo `.env` y actualiza las variables de entorno, especialmente la configuración de la base de datos:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```

## Generar una Clave de Aplicación

4. Para generar una clave de aplicación, ejecuta el siguiente comando:

    ```bash
    php artisan key:generate
    ```

## Creación de la Base de Datos

5. Para crear la base de datos con datos iniciales, ejecuta el siguiente comando:

    ```bash
    php artisan migrate --seed
    ```

## Ejecutar Pruebas

6. Para correr los tests, utiliza el siguiente comando:

    ```bash
    php artisan test
    ```


 extencione a habilitar en php.ini
    extension=zip

extension=fileinfo

