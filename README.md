# 🌱 EcoHuerta Smart

Proyecto final integrador que combina **Laravel**, **IoT** y **riego automatizado**, orientado a la gestión inteligente de huertas mediante sensores, actuadores y una API REST.

---

## 📌 Descripción general

**EcoHuerta Smart** es una plataforma web desarrollada en **Laravel** que permite:

- Monitorear sensores ambientales y de suelo
- Gestionar cultivos, productores y dispositivos IoT
- Automatizar el riego según reglas agronómicas
- Visualizar información en tiempo real mediante dashboard
- Integrarse con dispositivos **ESP32** a través de una **API REST**

El sistema está pensado para pequeñas y medianas huertas, con foco en la **optimización del uso del agua** y la **toma de decisiones basada en datos**.

---

## 🧠 Tecnologías utilizadas

### Backend
- PHP 8.x
- Laravel
- Laravel Livewire
- API REST
- Laravel Reverb (eventos / tiempo real)

### Frontend
- Blade Templates
- Livewire
- HTML5 / CSS3
- JavaScript

### Base de datos
- MySQL / MariaDB
- Migraciones y Seeders

### IoT
- ESP32
- Sensores de humedad de suelo
- Sensores ambientales
- Actuadores (válvulas / relés)
- Comunicación vía HTTP (API REST)

---

## ⚙️ Funcionalidades principales

- 📊 Dashboard interactivo
- 🌾 Gestión de cultivos y etapas de crecimiento
- 📡 Gestión de sensores y actuadores
- 💧 Automatización del riego
- 📈 Cálculo agronómico de riego
- 🔔 Sistema de alertas y notificaciones
- 👨‍🌾 Gestión de productores
- ⏱️ Programación de horarios de riego
- 📬 Envío de correos de prueba
- 🔐 Autenticación de usuarios

---

## 🗂️ Estructura del proyecto

- `app/Http/Controllers` → Controladores API y Web
- `app/Models` → Modelos Eloquent
- `app/Services` → Lógica de negocio (cálculo de riego)
- `app/Livewire` → Componentes del dashboard
- `routes/api.php` → Endpoints para ESP32
- `routes/web.php` → Rutas web
- `resources/views` → Vistas Blade
- `database/migrations` → Estructura de base de datos
- `public/` → Recursos públicos

---

## 🔌 Integración IoT (ESP32)

El ESP32 se comunica con el sistema mediante una **API REST**, enviando:

- Lecturas de sensores
- Estado de riego
- Progreso de riego

El backend procesa estos datos y decide acciones automáticas según reglas configuradas.

---

## 🚀 Instalación básica

```bash
git clone https://github.com/Sergio-Valentino/ecohuerta-smart.git
cd ecohuerta-smart
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

## 🎓 Contexto académico

Este proyecto fue desarrollado como **Trabajo Final Integrador**, aplicando conocimientos adquiridos en la formación técnica en programación.

Durante su desarrollo se pusieron en práctica los siguientes contenidos:

- Desarrollo de aplicaciones web con arquitectura MVC  
- Programación backend con PHP y Laravel  
- Diseño e implementación de APIs REST  
- Integración con dispositivos IoT (ESP32)  
- Automatización de procesos (riego inteligente)  
- Modelado y gestión de bases de datos relacionales  
- Aplicación de buenas prácticas de desarrollo de software  
- Verificación y validación del funcionamiento del sistema  

El proyecto integra software y hardware con el objetivo de resolver una problemática real vinculada a la producción agrícola y al uso eficiente del agua.

## 👤 Autor

**Sergio Valentino Romero**  
Técnico en Programación  
Desarrollador Backend / IoT  

Tecnologías:  
Laravel · PHP · Livewire · MySQL · API REST · ESP32 · IoT

## 📄 Licencia

Este proyecto se desarrolla con fines **académicos y educativos**.  
El código puede ser utilizado como material de estudio y referencia, sin fines comerciales.

📡 Documentación de la API
Introducción

La API de EcoHuerta Smart permite la comunicación entre el sistema backend desarrollado en Laravel y dispositivos IoT basados en ESP32.
Su objetivo principal es recibir lecturas de sensores, gestionar procesos de riego automático y proveer información al panel web de control.
La comunicación se realiza mediante el protocolo HTTP utilizando el formato JSON.


Tecnologías utilizadas
Backend: Laravel
Lenguaje: PHP
Protocolo: HTTP / REST
Formato de datos: JSON
Base de datos: MySQL
Dispositivos: ESP32


URL base
Durante el desarrollo local, la API se encuentra disponible en:
http://localhost:8000/api


Autenticación

Algunos endpoints requieren autenticación mediante token.
El token debe enviarse en el encabezado de la solicitud:

Authorization: Bearer {token}



Endpoints principales
Registrar lecturas de sensores

POST /lecturas

Este endpoint recibe los datos enviados por el ESP32 y los almacena en la base de datos.

Ejemplo de solicitud (JSON):

{
  "sensor_id": 1,
  "humedad_suelo": 45,
  "temperatura": 26,
  "humedad_ambiente": 60
}


Ejemplo de respuesta:

{
  "success": true,
  "message": "Lectura registrada correctamente"
}




Iniciar riego

POST /riego/iniciar
Inicia el proceso de riego automático para un cultivo o sector determinado.
Finalizar riego
POST /riego/finalizar
Finaliza el riego y registra la duración y el consumo estimado.



Manejo de errores
La API puede devolver los siguientes códigos de estado:
200 OK – Solicitud exitosa
400 Bad Request – Error en los datos enviados
401 Unauthorized – No autorizado
500 Internal Server Error – Error interno del servidor



Flujo de comunicación

El flujo general del sistema es el siguiente:
ESP32 → API Laravel → Base de Datos → Panel Web
El ESP32 envía datos de sensores, la API los procesa y almacena, y el panel web muestra la información en tiempo real o de forma histórica.



Licencia

Este proyecto se distribuye con fines educativos y académicos.
El código puede ser utilizado, modificado y distribuido libremente con fines no comerciales.
