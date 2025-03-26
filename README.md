<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel + Vue Project

Este proyecto combina Laravel como backend y Vue.js como frontend para crear una aplicación web moderna y escalable, que toma como referencia e inspiración un sistema de Seguros Agrícolas.

## Requisitos Previos

Asegúrate de tener instalados los siguientes componentes en tu sistema:

- PHP >= 8.0
- Composer
- Node.js >= 16.x
- NPM
- MySQL

## Instalación

1. Clona el repositorio:

   ```sh
   git clone <URL_DEL_REPOSITORIO>
   cd laravel-vue
   ```

2. Instala las dependencias de PHP:

   ```sh
   composer install
   ```

3. Instala las dependencias de Node.js:

   ```sh
   npm install
   ```

4. Copia el archivo de entorno y configura las variables necesarias:

   ```sh
   cp .env.example .env
   ```

   Edita el archivo `.env` para configurar la conexión a la base de datos y otras variables.

5. Genera la clave de la aplicación:

   ```sh
   php artisan key:generate
   ```

## Migraciones y Seeders

Ejecuta las migraciones para crear las tablas en la base de datos:

```sh
php artisan migrate
```

Los respectivos seeders, puedes ejecutarlos con:

```sh
php artisan db:seed
```

## Servidor de Desarrollo (Laravel 12)

Debido al upgrade que tuvo el proyecto (Laravel 11 -> Laravel 12), ya no es necesario ejecutar los comandos en distintos terminales, solamente con este comando debería ser suficiente:

```sh
compose run dev
   ```

Accede a la aplicación en `http://localhost:8000`.

## Estructura del Proyecto

- **app/**: Contiene el código principal de la aplicación, incluyendo controladores, modelos y proveedores.
- **bootstrap/**: Configuración inicial del framework.
- **config/**: Archivos de configuración de la aplicación.
- **database/**: Migraciones, seeders y otros archivos relacionados con la base de datos.
- **public/**: Carpeta pública que contiene el archivo `index.php` y otros recursos accesibles públicamente.
- **resources/**: Vista Blade, archivos de Vue.js y otros recursos frontend.
- **routes/**: Archivos de rutas de la aplicación.
- **storage/**: Archivos generados por la aplicación, como logs y caché.
- **tests/**: Pruebas automatizadas.
- **vendor/**: Dependencias instaladas por Composer.

## Contribuciones

Si deseas contribuir a este proyecto, por favor abre un issue o envía un pull request.

## Licencia

Este proyecto está licenciado bajo la [MIT License](LICENSE).
