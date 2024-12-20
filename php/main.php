<?php

    #Conexion a la base de datos
    function conexion(){
        $pdo = new PDO('mysql:host=localhost; dbname=inventario', 'root', 'admin123');
        return $pdo;
    }
?>