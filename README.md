# 🌺 Florería Orlandito - E-commerce y Gestión de Inventario

![Estado](https://img.shields.io/badge/Estado-Terminado-brightgreen)
![Versión](https://img.shields.io/badge/Versión-1.0-blue)
![PHP](https://img.shields.io/badge/Backend-PHP%208-purple)
![MySQL](https://img.shields.io/badge/DB-MariaDB-orange)

## 📖 Descripción

**Florería Orlandito** es una plataforma web integral diseñada para optimizar la venta y administración de arreglos florales. El sistema se divide en dos módulos:

1.  **Catálogo Público (Frontend):** Permite a los clientes visualizar productos, filtrar por categorías, agregar al carrito y realizar pedidos con control de stock en tiempo real.
2.  **Panel Administrativo (Backend):** Un entorno seguro para que el administrador gestione el inventario, actualice precios y administre el estado de los pedidos.

## 🚀 Características Principales

### 🛒 Para el Cliente
* **Catálogo Interactivo:** Filtrado dinámico (Ramos, Frutales, Ocasión) sin recargas de página.
* **Carrito de Compras:** Gestión de productos en tiempo real con JavaScript.
* **Integración de Pagos:**
    * 💳 **PayPal:** Pasarela de pagos funcional.
    * 💵 **Efectivo:** Generación automática de **Ticket de Compra** imprimible.
* **Validación de Stock:** El sistema impide comprar productos agotados protegiendo la integridad del inventario.

### 🔐 Para el Administrador
* **Seguridad:** Login con sesiones y contraseñas encriptadas (`password_hash`).
* **Gestión de Inventario (CRUD):** Alta, baja y modificación de productos e imágenes.
* **Control de Pedidos:** Visualización de ventas y actualización de estados (Pendiente, Entregado, Cancelado).
* **Protección de Datos:** Uso de *Prepared Statements* para prevenir inyección SQL.

## 🛠️ Tecnologías

* **Frontend:** HTML5, CSS3 (Diseño Responsive), JavaScript (Vanilla).
* **Backend:** PHP (Nativo).
* **Base de Datos:** MySQL / MariaDB.
* **Librerías:** PayPal SDK.

## 📋 Instalación y Configuración

Sigue estos pasos para desplegar el proyecto en tu servidor local (XAMPP, WAMP, Laragon):

### 1. Base de Datos
1. Abre **phpMyAdmin**.
2. Crea una nueva base de datos llamada `floreria_db`.
3. Ve a la pestaña **Importar** y selecciona el archivo `floreria_db.sql` incluido en este repositorio.
   * *Nota: Esto creará las tablas y cargará productos de prueba automáticamente.*

### 2. Conexión
Asegúrate de que el archivo `admin/conexion.php` (o `conexion.php`) tenga tus credenciales locales:
```php
$servidor = "localhost";
$usuario = "root";
$password = ""; // Tu contraseña de MySQL (vacía en XAMPP por defecto)
$base_datos = "floreria_db";