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

#Limpiar cadena de texto
function limpiar_cadena($cadena){
    $cadena =trim($cadena);
    $cadena=stripslashes($cadena);
    $cadena=str_ireplace("<script>","",$cadena);
    $cadena = str_ireplace("</script>", "", $cadena);
    $cadena = str_ireplace("<script src", "", $cadena);
    $cadena = str_ireplace("<script type=", "", $cadena);
    $cadena = str_ireplace("SELECT * FROM", "", $cadena);
    $cadena = str_ireplace("DELETE FROM", "", $cadena);
    $cadena = str_ireplace("INSERT INTO", "", $cadena);
    $cadena = str_ireplace("DROP TABLE", "", $cadena);
    $cadena = str_ireplace("DROP DATABASE", "", $cadena);
    $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena = str_ireplace("SHOW TABLES;", "", $cadena);
    $cadena = str_ireplace("SHOW DATABASES;", "", $cadena);
    $cadena = str_ireplace("<?php", "", $cadena);
    $cadena = str_ireplace("?>", "", $cadena);
    $cadena = str_ireplace("--", "", $cadena);
    $cadena = str_ireplace("^", "", $cadena);
    $cadena = str_ireplace("<", "", $cadena);
    $cadena = str_ireplace("[", "", $cadena);
    $cadena = str_ireplace("]", "", $cadena);
    $cadena = str_ireplace("==", "", $cadena);
    $cadena = str_ireplace(";", "", $cadena);
    $cadena = str_ireplace("::", "", $cadena);
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    return $cadena;
}

$texto="<script> Hola Mundo</script>";
echo limpiar_cadena($texto);


?>
