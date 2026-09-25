# Sistema de Gestión de Estudiantes - Pila en PHP Nativo

Este proyecto implementa el comportamiento de una estructura de datos *Pila (Stack)* utilizando arreglos nativos de PHP e índices lógicos para simular una pila estática. La persistencia de los datos se maneja a través de variables de sesión, y la interfaz utiliza formularios HTML5 puros, sin depender de ningún framework de desarrollo.

## Herramientas y Requisitos Necesarios
Para desplegar y ejecutar este proyecto, necesitas un entorno de servidor web local:
-PHP: Versión 8.0 o superior.
- Servidor Web: Apache (incluido en suites como XAMPP, WampServer, MAMP o mediante contenedores Docker).
- Navegador Web: Cualquier navegador moderno para interactuar con la interfaz HTML.

## Instrucciones de Clonación e Instalación

1. **Clonar el repositorio:**
   Asegúrate de ejecutar este comando dentro de la carpeta de despliegue de tu servidor web (por ejemplo, `C:\xampp\htdocs\` en XAMPP o `/var/www/html/` en Linux):
 
   cd /ruta/a/tu/servidor/htdocs
   git clone https://gitlab.com
 
2. **Navegar al directorio del proyecto:**
  
   cd pila_estudiantes
   
## Ejecución y Despliegue

1. Inicia los servicios de **Apache** desde el panel de control de tu herramienta local (ej. XAMPP Control Panel).
2. Abre tu navegador web de preferencia.
3. Accede a la URL local apuntando a la carpeta clonada:
   http://localhost/pila_estudiantes/index.php

## Uso de la Aplicación
* Formulario HTML:Permite ingresar la información del estudiante (atributos de texto, tipo fecha y selección de género). Los datos se añaden al arreglo simulando el crecimiento de la pila. El límite del arreglo está parametrizado a un máximo de 10 elementos.
* Botón de Acción: Ejecuta la función interna de desapilado, eliminando del arreglo global el último registro e informando al usuario el nombre del estudiante retirado.
* Visualización: El script lee el arreglo en orden LIFO y dibuja bloques HTML de manera descendente (el *Tope* actual de la pila se renderiza arriba del todo).
