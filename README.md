# Festival Literario - Plataforma de Gestión Integral (Full-Stack)

Esta plataforma web es un sistema integral para la gestión de festivales literarios. Permite administrar de forma centralizada escritores, editoriales, libros, localizaciones y eventos, incluyendo un sistema de inscripción para usuarios finales.

El proyecto está construido siguiendo el patrón **MVC (Modelo-Vista-Controlador)** y destaca por implementar una arquitectura de persistencia propia basada en **ActiveRecord**, garantizando un código limpio, modular y escalable.

### Arquitectura
* **ActiveRecord Pattern:** Implementación de un ORM (Object-Relational Mapping) personalizado para abstraer la lógica de la base de datos, cumpliendo con el principio **DRY** (Don't Repeat Yourself).
* **Router Dinámico:** Sistema de ruteo que gestiona URLs amigables y renderizado de vistas dinámicas, separando la lógica de negocio de la presentación.
* **Control de Acceso (RBAC):** Middleware para la gestión de roles (Administrador vs Usuario), protegiendo rutas sensibles y operaciones críticas.

### Seguridad y Robustez
* **Prevención de Vulnerabilidades:** Uso de sentencias preparadas para evitar **Inyección SQL** y sanitización de datos mediante `htmlspecialchars` para prevenir ataques **XSS**.
* **Autenticación Avanzada:** Gestión de sesiones segura y hashing de contraseñas mediante `BCRYPT`.

### Diseño de Base de Datos (SQL)
* **Integridad Referencial:** Esquema relacional con restricciones de clave foránea (`RESTRICT` / `CASCADE`) para asegurar la consistencia de los datos.
* **Optimización:** Uso de índices estratégicos en columnas de búsqueda frecuente y claves únicas para evitar duplicidad de registros (ej. inscripciones múltiples).

### Frontend & Multimedia
* **Asset Bundling:** Optimización de recursos JavaScript mediante minificación y bundling para mejorar el rendimiento de carga.
* **Procesamiento de Imágenes:** Integración con `Intervention Image` para redimensionar y convertir archivos multimedia a formatos modernos (WebP).

## Tecnologías Utilizadas

* **Backend:** PHP 8.x (POO)
* **Base de Datos:** MySQL / MariaDB
* **Frontend:** JavaScript (ES6+), SASS/CSS3, Swiper.js
* **Gestión de Dependencias:** Composer, NPM
* **Entorno:** Variables de entorno con `.env`

---
*Desarrollado con enfoque en arquitectura limpia y seguridad.*
