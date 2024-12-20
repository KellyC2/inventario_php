<?php
# Conexión a la base de datos
function conexion()
{
    $config = include('config.php');
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']}";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
    return $pdo;
}

#Verificar datos
function Verificar_datos($filtro, $cadenaAVerificar){
    if(preg_match("/^".$filtro."$/", $cadenaAVerificar)){
        return false;
    }else{
        return true;
    }

}

$nombre="Carlos5256";
if(Verificar_datos("[a-zA-Z]{6,10}", $nombre)){
    echo "Los datos no coinciden";
}



?>
