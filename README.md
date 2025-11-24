# Microservicio de Autenticación (PRY_AUTENTICACION_MICROSERVICIO) – Grupo 3

Proyecto desarrollado en **Laravel 12** como parte de la materia **Arquitectura de Software**.  
Este microservicio implementa un **sistema de autenticación basado en tokens** utilizando **Laravel Sanctum**, permitiendo validar accesos desde otros microservicios del sistema distribuido.

Este servicio es el encargado oficial de **registrar usuarios**, **iniciar sesión**, **generar tokens**, **validar tokens** y **cerrar sesión**, funcionando como el punto central de autenticación en la arquitectura de microservicios.

---

## Objetivos del Proyecto

Implementar un microservicio de autenticación que permita a otros servicios validar usuarios mediante **tokens generados con Laravel Sanctum**.

Este microservicio permite:

- Registrar usuarios con un **perfil** (admin, editor, user).
- Iniciar sesión y generar un **token de acceso**.
- Validar si un token es válido mediante `/api/validate-token`.
- Cerrar sesión eliminando el token actual.
- Proteger rutas mediante `auth:sanctum`.
- Utilizar MySQL como base de datos.

Este servicio actuará como el **proveedor de autenticación** para el resto de microservicios, como el microservicio de Posts.

---

## Requerimientos Previos

Antes de ejecutar el proyecto tener instalado:

- PHP 8.2.12  
- Composer  
- Laravel 12  
- XAMPP 8.2.12 (MySQL)  
- Node.js  
- Postman (Pruebas del API)

---

## Configuración del API

Laravel 12 incluye Laravel Sanctum por defecto mediante el comando:  
- php artisan install:api  

Esto crea automáticamente las configuraciones necesarias para la autenticación por tokens y las rutas iniciales para el microservicio.

En la pregunta:
-  One new database migration has been published. Would you like to run all pending database migrations?
Responder: **yes**

Luego se creó el controlador y las solicitudes:
- php artisan make:controller Api/AuthController
- php artisan make:request RegisterRequest
- php artisan make:request LoginRequest

**Importante**
Solo ejecutar esos comandos si se crea un proyecto desde cero, si se clona desde el repsitorio de GitHub no es necesario ejecutarlos.

---

## Instalación del Proyecto

1. Clonar el repositorio desde GitHub:
    - git clone https://github.com/EderJAndrade/pry_autenticacion_microservicio.git

2. Ingresar al directorio del proyecto:
    - cd pry_autenticacion_microservicio

3. Instalar las dependencias de Laravel:
    - composer install

4. Copiar el archivo de entorno y configurarlo:
    - cp .env.example .env

5. Generar la clave de aplicación:
    - php artisan key:generate

---

## Configuración de la Base de Datos

1. Crear la base de datos en MySQL:
    - CREATE DATABASE IF NOT EXISTS pry_autenticacion_grupo3 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    - CREATE USER IF NOT EXISTS 'auth_g3_user'@'localhost' IDENTIFIED BY 'AuthG3!';
    - GRANT ALL PRIVILEGES ON pry_autenticacion_grupo3.* TO 'auth_g3_user'@'localhost';
    - FLUSH PRIVILEGES;

2. En el archivo .env configurar la conexión:
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=pry_autenticacion_grupo3
    - DB_USERNAME=auth_g3_user
    - DB_PASSWORD=AuthG3!

---

## Migraciones

Ejecutar las migraciones con:
- php artisan migrate:fresh --seed  

Este comando limpia y vuelve a crear todas las tablas.

---

## Estructura del Proyecto

app/Http/Controllers/Api/
- AuthController.php

app/Http/Request/
- LoginRequest.php
- RegisterRequest.php

app/Models/
- User.php

database/migrations/
- create_users_table.php

routes/
- api.php

---

## Endpoints Principales (API)

Iniciar el proyecto con el comando:
- php artisan serve

**En Postman**

**Crear un nuevo usuario**
- **POST** /api/register

*Headers*
- Accept: application/json

*Body - raw - JSON*

{
  "name": "Eder Andrade",
  "email": "ederandrade@grupo3.com",
  "password": "123456789",
  "password_confirmation": "123456789",
  "telefono": "0987654321",
  "perfil": "admin"
}

Genera el Token.

**Iniciar Sesión**
- **POST** /api/login

*Body - raw - JSON*

{
  "email": "admin@grupo3.com",
  "password": "admin123"
}

Devuelve el token de autorización.

**Validar Token**
- **GET** /api/validate-token

*Headers*
- Accept: application/json
- Authorization: Bearer COPIAR_TOKEN

**EJEMPLO**
- Authorization: Bearer 1|lbOAWBGwDqHKvE8rzI0vO8UgGKwvgCtt6WTzWzu5a651ea62

Devuelve el usuario registrado de acuerdo al token ingresado.

**Cerrar Sesión**
- **POST** api/logout

*Headers*
- Authorization: Bearer COPIAR_TOKEN

Saldra el mensaje "Sesión cerrada (token revocado)" y en la base de datos se eliminara el registro del token.

---

## Autores

**Universidad de las Fuerzas Armadas ESPE** 

**Grupo 3 - Arquitectura de Software**  
- Aguilar Mijas Laura Estefanía  
- Andrade Alvarado Eder Jonathan  
- Bucay Pallango Carlos Avelino  
- Cisneros Cárdenas Freddy Gabriel  
- Pita Clemente Karina Annabel   

Docente: *Vilmer David Criollo Chanchicocha*  

**2025**