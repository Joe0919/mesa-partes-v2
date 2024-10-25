
# Sistema de Mesa de Partes Virtual

Mesa de Partes Virtual es un sistema web desarrollado en PHP con arquitectura MVC, que permite gestionar trámites de manera virtual. Este sistema facilita a los usuarios presentar, derivar, aceptar, rechazar y archivar documentos. El sistema está optimizado para manejar múltiples usuarios y roles, incluyendo administradores y usuarios invitados, y cuenta con una interfaz dinámica impulsada por JavaScript y jQuery.

## Características principales

- Gestión de trámites con distintos estados: Aceptado, Rechazado, Archivado, Derivado y Observado.
- Registro y login de usuarios con distintos roles (invitados y asignación de áreas).
- Envío de documentos en PDF y control de estados.
- Funcionalidad de derivación de trámites entre áreas.
- Estadísticas de documentos gestionados por cada área.
- Validación de campos en el frontend con JavaScript/jQuery.
- Soporte para usuarios no logueados que pueden subir documentos sin asignación de área.
- Manejo asíncrono de datos mediante AJAX.
- Generación de Reportes en PDF.

## Tecnologías utilizadas
- Backend: PHP (Modelo-Vista-Controlador - MVC)
- Frontend: HTML, CSS, JavaScript, jQuery
- Base de datos: MySQL
- Servidor Local Xampp
- AJAX: Para solicitudes asíncronas
- Control de versiones: Git/GitHub
- PHP Mailer para envio de correos
- DomPDF para generar Reportes

## Requisitos
Antes de instalar el sistema, asegúrate de que tu servidor cumpla con los siguientes requisitos:

- PHP 8.2+
- MySQL 15.1+
- Servidor Apache
- Extensión PDO de PHP
- Composer (para la gestión de dependencias)
- Node.js y npm (para la gestión de recursos frontend si usas alguna herramienta como Webpack o Gulp)

## Funcionalidades
### Gestión de documentos
- Los usuarios pueden enviar documentos en formato PDF.
- Los documentos pueden tener varios estados: Aceptado, Rechazado, Derivado, Observado y Archivado.
- Los documentos observados pueden ser corregidos y reenviados sin perder el número de expediente.
### Derivación entre áreas
- Los administradores pueden derivar documentos a diferentes áreas para su gestión.
- Cada área puede ver un historial de documentos derivados y en qué estado se encuentran.
### Estadísticas
- El sistema muestra un ranking de las áreas con mayor número de documentos gestionados.
- Los administradores pueden acceder a estadísticas del sistema para análisis.

# Licencia
- Este proyecto fue realizado por Joel Llallihuamán.

# Contacto
Si tienes alguna duda o sugerencia sobre el sistema, no dudes en contactarme:

- Correo: joel09llalli@gmail.com
- Github : [Joel Llallihuaman](https://github.com/Joe0919)
- Instagram : [Joel Llallihuaman](https://www.instagram.com/jo3l_llalli/)
- Facebook : [Joel Llallihuaman](https://web.facebook.com/joelvladimir.lg)
- Linkedin : [Joel Llallihuaman Giraldo](https://www.linkedin.com/in/joel-llalli)
