
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

## Pasos para configurar el proyecto

#### Clonar el repositorio

Ejecute lo siguiente en la terminal:

```
git clone https://github.com/Joe0919/mesa-partes-v2.git
cd mesa-partes-v2
```

### Configurar el entorno local

- Instala XAMPP o cualquier otro servidor local que incluya PHP y MySQL.
Asegúrate de que Apache y MySQL estén en ejecución.

## Crear la base de datos

Accede a phpMyAdmin o usa la terminal de MySQL. En mi caso use Mysql Query Browser 1.1.20 con la herramienta MYSQL Administrator para el backup y el restore

- Abra la carpeta Databases en la cual puede encontrar el backup asi como el modelo lógico de la BD y realice el Restore

Tener en cuenta que se uso CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci si presenta problemas de compatibilidad.

### Configurar el archivo de conexión

Ve al archivo .env.example y elimine .example actualiza las credenciales de conexión a la base de datos:
```
DB_DRIVER=mysql
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=db_mesapartes
DB_CHARSET=utf8

URL=http://localhost/MesaPartesVirtual
BASE_PATH=/var/www/html/MesaPartesVirtual
UPLOADS_PATH=/var/www/html/MesaPartesVirtual/public/files/

SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USERNAME=su correo gmail
SMTP_PASSWORD=su pasword de aplicaciones de gmail para que el plugin phpMailer funcione correctamente
```

### Instalar dependencias con Composer

Por defecto el proyecto tiene instaladas las dependencias:
```
 "phpmailer/phpmailer": "^6.9",
 "dompdf/dompdf": "^3.0",
 "vlucas/phpdotenv": "^5.6"
```
Sin embargo si tuviera problemas puede eliminarlas en la carpeta vendor y realizar lo siguiente:

Asegúrate de tener Composer instalado.
En la raíz del proyecto, ejecuta:

```
composer install
```

### Levantar el servidor local

Coloca el proyecto en el directorio de tu servidor local (por ejemplo, en la carpeta htdocs de XAMPP).
Accede al sistema desde tu navegador en la URL:
```
http://localhost/MesaPartesVirtual/
```

### Credenciales iniciales

- DNI: 12345678
- Contraseña: administrador


### Probar funcionalidades

Ingresa al sistema con las credenciales iniciales.
Prueba la gestión de documentos, derivaciones y estadísticas para asegurarte de que todo funcione correctamente.

### Contribuir

Si deseas realizar cambios y contribuir al proyecto:
Crea una rama nueva:

```
git checkout -b mi_rama
```
Realiza tus cambios y súbelos:
```
git add .
git commit -m "Descripción de los cambios"
git push origin mi_rama
```
Abre un Pull Request en GitHub.


# Licencia
- Este proyecto fue realizado por Joel Llallihuamán.

# Contacto
Si tienes alguna duda o sugerencia sobre el sistema, o informar sobre errores, no dudes en contactarme:

- Correo: joel09llalli@gmail.com
- Github : [Joel Llallihuaman](https://github.com/Joe0919)
- Instagram : [Joel Llallihuaman](https://www.instagram.com/jo3l_llalli/)
- Facebook : [Joel Llallihuaman](https://web.facebook.com/joelvladimir.lg)
- Linkedin : [Joel Llallihuaman Giraldo](https://www.linkedin.com/in/joel-llalli)
