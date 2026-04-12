# PR Intra Back

Backend del proyecto construido con Laravel.

## Arquitectura del proyecto

Este proyecto está planteado como un backend para una intranet de práctica, con una arquitectura MVC propia de Laravel y separación por responsabilidades.

### Capas principales

- Capa HTTP: entrada de peticiones, controladores y validaciones (controllers y form requests).
- Capa de dominio: modelos Eloquent que representan las entidades de negocio.
- Capa de persistencia: migraciones, factories y seeders para estructura y datos base.
- Capa de tiempo real: eventos y broadcasting para mensajería interna.

### Módulos funcionales

- Usuarios y permisos: gestión de usuarios, roles y departamentos.
- Comunicación interna: conversaciones, mensajes y trazabilidad de lectura.
- Contenido interno: anuncios, comentarios y documentos.

### Estructura base

- app/Models: entidades principales de la intranet.
- app/Http/Controllers: endpoints y lógica de orquestación.
- app/Http/Requests: validación de datos de entrada.
- app/Events: eventos para comunicación en tiempo real.
- routes/: definición de rutas web, API, canales y consola.
- database/migrations: definición de tablas y relaciones.

### Flujo general

1. El cliente consume endpoints del backend.
2. El controlador delega validación y reglas de negocio.
3. Los modelos interactúan con la base de datos.
4. Cuando aplica, se disparan eventos para broadcasting.

## Instalación

Ejecuta los siguientes comandos **en este orden** (obligatorio):

1. Instalar dependencias de PHP

```bash
composer install
```

2. Instalar dependencias de Node.js

```bash
npm install
```

3. Instalar broadcasting de Laravel

```bash
php artisan install:broadcasting
```

4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

## Ejecutar en Windows

```bash
php artisan serve --no-reload --host=127.0.0.1 --port=8000
```

