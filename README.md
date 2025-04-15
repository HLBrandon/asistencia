# Sistema Pase de Lista ITSMT
El proyecto "Sistema de Pase de Lista ITSMT" fue desarrollado para la asignatura Taller de Desarrollo de Software. El objetivo del proyecto consistió en diseñar un sistema que facilitara la toma de asistencia por parte de los docentes de la institución. Se identificó que los docentes emplean hojas de cálculo en Excel para registrar la asistencia; no obstante, cada docente utiliza su propia plantilla, lo que genera inconsistencias. Además, un asistente del área administrativa realiza un pase adicional de asistencia en las aulas y más tarde comparan las asistencias del docente con las capturadas con el asistente. Por lo tanto, se decidió abordar esta problemática y desarrollar un sistema que representara una solución eficiente para la institución.

## Caracteristicas
- Gestión de usuarios.
- Gestión de asistencias.
- Generación de reportes PDF.
- Gestión de horarios.
- Gestión de alumnos.
- Gestión de grupos.
- Gestión de periodos escolares.
- Gestión de sistemas (Escolarizado y Mixto)
- Gestión de asignaturas.

## Tecnologías implementadas
En el desarrollo del proyecto "Sistema de Pase de Lista" se emplearon diversas tecnologías que facilitaron su implementación. Se utilizó el lenguaje de programación PHP 8.2 junto con HTML y CSS básico para la creación de la estructura y el diseño. Bootstrap fue la herramienta principal para estilizar las vistas, proporcionando un diseño limpio y responsivo. Además, se hizo uso de JS, destacando el uso de la librería jQuery para manipular elementos dinámicos y mejorar la interactividad. Para el almacenamiento de datos, se optó por una base de datos en MySQL, utilizando un enfoque procedimental de programación que permitió una organización eficiente y estructurada.

### Instalación
Tras descargar o clonar el repositorio, es necesario ejecutar el comando `composer install` desde la terminal. Es importante asegurarse de estar dentro del directorio que contiene el proyecto y de tener Composer instalado previamente. De esta forma, se descargarán las dependencias de [PHPSpreadsheet](https://phpspreadsheet.readthedocs.io/en/latest/ "PHPSpreadsheet") y [FPDF](https://www.fpdf.org/ "FPDF").

En la carpeta `database/asistencia_app.sql` se encuentra el archivo SQL de la base de datos, el cual puede ser importado mediante phpMyAdmin o MySQL Workbench.

Dentro de la carpeta `config/config.php` se encuentran las variables de configuración del sistema, las cuales son:

- Definición de la zona horaica e idioma.
- Definición de la raiz del proyecto y las siglas de la institución.
- Definición de las variables para la conexión de la base de datos.

### Credenciales del Administrador
- Correo: programador@example.com
- Contraseña: Admin123