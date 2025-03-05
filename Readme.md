# Notas importantes sobre el ejercicio

##  1- Se supone que tienes un entorno de desarrollo en tu máquina local con las siguientes características:

- PHP 8.2 o superior
- Composer
- Git 
- MySQL o MariaDB
- Nginx o Apache

## 2-  La base de datos de test debe ser mysql o mariaDB y debe llamarse `mysql_testing` tal como se indica en el archivo `phpunit.xml`



```xml
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_DATABASE" value="mysql_testing"/>
```

## 3- Para ejecutar las pruebas  debes ejecutar el siguiente comando en la raíz del proyecto

```bash
php artisan test
```

## 4- El objetivo es que todos los test de la clase `GeneralTest.php` pasen correctamente.

La clase `GeneralTest.php` se encuentra en la carpeta `tests/Feature` y contiene 8 test que actualmente fallan a proposito y la tarea consiste en conseguir que todos funcionen y ponerlos en verde.


