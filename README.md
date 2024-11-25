<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

El siguiente proyecto en Laravel requiere de los siguientes pasos para su instalacion y ejecucion. 

-Bajar e instalar XAMPP desde https://www.apachefriends.org/es/index.html y seguir los pasos indicados (XAMPP ya viene con PHP por defecto, en caso de que su sistema no lo detecte en la linea de comandos debera agregarlo al PATH).
-Bajar e instalar Composer desde https://getcomposer.org/download/ y seguir los pasos.
-Bajar e instalar Git, e incluir en la instalacion Git Bash, ya que los comandos utilizados se probaron en dicho shell.
-Dentro de la carpeta donde se haya instalado XAMPP debera buscar la carpeta php, y dentro de esta el archivo php.ini. 
-En dicho archivo debera buscar mediante "ctrl + f" la palabra "extension" y buscar los elementos que contengan "=zip" e "=gd" y elimninar la ";" de dichos elementos para habilitarlos. Esto permite la instalacion más adelante de la biblioteca phpSpreadSheet.
-Ejecute XAMPP. Una vez abierto, debera darle Start al modulo de Apache y MySQL.
-Dentro de la carpeta de XAMPP nuevamente, buscar la carpeta htdocs. En dicha carpeta abrir una linea de comandos de Git Bash.
-Ingresar el comando sin comillas "git clone https://github.com/JuanCobas/gestion-escolar".
-Con el proyecto clonado, busque el archivo ".env.example" y modifiquelo borrando ".example" quedando ".env". En dicho archivo debera configurar su coneccion a la base de datos. En este caso, ya deberia estar listo para conectarse a su base de datos local de XAMPP con el nombre de "admin_escuela"

-Nuevamente en Git Bash ingrese el comando "composer install", el cual instalara todas las dependencias necesarias.
-Una vez terminado, debera realizar las migraciones y correr el seed para cargar la base de datos. Utilice el comando "php artisan migrate --seed". Si desea hacer una migracion desde cero, puede utilizar el comando "php artisan migrate:fresh --seed".
-Por ultimo corra el siguiente comando "php artisan serve", el cual deberia arrancar la aplicacion.  
