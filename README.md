<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

El siguiente proyecto en Laravel requiere de los siguientes pasos para su instalación y ejecución. 

-Bajar e instalar XAMPP desde https://www.apachefriends.org/es/index.html y seguir los pasos indicados (XAMPP ya viene con PHP por defecto, en caso de que su sistema no lo detecte en la línea de comandos deberá agregarlo al PATH).

-Bajar e instalar Composer desde https://getcomposer.org/download/ y seguir los pasos.

-Bajar e instalar Git, e incluir en la instalación Git Bash, ya que los comandos utilizados se probaron en dicho shell.

-Dentro de la carpeta donde se haya instalado XAMPP deberá buscar la carpeta php, y dentro de esta el archivo php.ini. 

-En dicho archivo deberá buscar mediante "ctrl + f" la palabra "extension" y buscar los elementos que contengan "=zip" e "=gd" y eliminar la ";" de dichos elementos para habilitarlos. Esto permite la instalación más adelante de la biblioteca phpSpreadSheet.

-Ejecute XAMPP. Una vez abierto, deberá darle click al botón Start a los módulos de Apache y MySQL.

-Dentro de la carpeta de XAMPP nuevamente, buscar la carpeta htdocs. En dicha carpeta abrir una línea de comandos de Git Bash.

-Ingresar el comando "composer global require laravel/installer".

-Ingresar el comando sin comillas "git clone https://github.com/JuanCobas/gestion-escolar".

-Con el proyecto clonado, busque el archivo ".env.example" y modifiquelo borrando ".example" quedando ".env". En dicho archivo debera configurar su coneccion a la base de datos. En este caso, ya debería estar listo para conectarse a su base de datos local de XAMPP con el nombre de "admin_escuela"

-Nuevamente en Git Bash ingrese el comando "composer install", el cual instalara todas las dependencias de php necesarias.

-Luego ingrese el siguiente comando "npm install". Cuando termine de cargar, ingrese "npm run dev". Luego apretar "ctrl + c".

-Una vez terminado, deberá realizar las migraciones y correr el seed para cargar la base de datos. Utilice el comando "php artisan migrate --seed". Si desea hacer una migración desde cero, puede utilizar el comando "php artisan migrate:fresh --seed".

-Por último corra el siguiente comando "php artisan serve", el cual debería arrancar la aplicación.
 
