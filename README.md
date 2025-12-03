# JONATHAN_SANDOVAL_AA5_EV01

Evidencia GA7-220501096-AA5-EV01\
Autor: Jonathan Sandoval\
Fecha: 2025-12-02

## Descripción del proyecto

Pruebas a la API creada previamente
## Requisitos

-   PHP 7.4 o superior
-   Extensión: PDO SQLite
-   Opcional:
    -   XAMPP / WAMP / LAMP\
    -   O servidor integrado de PHP

## Estructura principal del proyecto

    JONATHAN_SANDOVAL_AA5_EV01/
     ├── public/
     │   ├── register.php
     │   ├── login.php
     ├── src/
     │   ├── db.php
     │   ├── db_init.php
     ├── database.sqlite
     └── README.md

## Instalación rápida

### Clonar el repositorio

    git clone https://github.com/Curaprom06/JONATHAN_SANDOVAL_AA5_EV01.git

### Crear la base de datos

Ejecutar el script que genera `database.sqlite`:

    php src/db_init.php

### Ejecutar el servidor

#### Opción A --- XAMPP / WAMP

Mover el proyecto dentro de `htdocs` y abrir:

    http://localhost/JONATHAN_SANDOVAL_AA5_EV01/public/

#### Opción B --- Servidor integrado de PHP

Desde la raíz del proyecto:

    php -S localhost:8000 -t public

## Endpoints

### POST `/public/register.php`

Body JSON:

``` json
{
  "username": "usuario",
  "password": "secreto"
}
```

Respuesta:

``` json
{ "message": "Registro exitoso." }
```

### POST `/public/login.php`

Body JSON:

``` json
{
  "username": "usuario",
  "password": "secreto"
}
```

Posible respuesta:

``` json
{ "message": "Login exitoso." }
```

## Pruebas con cURL (Windows CMD)

### Registro:

    curl -X POST "http://localhost/JONATHAN_SANDOVAL_AA5_EV01/public/register.php" -H "Content-Type: application/json" -d "{\"username\":\"testuser\",\"password\":\"secret123\"}"

### Login:

    curl -X POST "http://localhost/JONATHAN_SANDOVAL_AA5_EV01/public/login.php" -H "Content-Type: application/json" -d "{\"username\":\"testuser\",\"password\":\"secret123\"}"

## 📎 Repositorio oficial

https://github.com/Curaprom06/JONATHAN_SANDOVAL_AA5_EV01
