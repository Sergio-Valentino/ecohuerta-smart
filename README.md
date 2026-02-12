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
