<?php
require_once"../php/main.php";

#Almacenando datos
$nombre=limpiar_cadena($_POST['usuario_nombre']);
$apellido=limpiar_cadena($_POST['usuario_apellido']);

$usuario= limpiar_cadena($_POST['usuario_usuario']);
$email=limpiar_cadena($_POST['usuario_email']);

$clave1=limpiar_cadena($_POST['usuario_clave_1']);
$clave2 = limpiar_cadena($_POST['usuario_clave_2']);

#Verificando campos obligatorios
if($nombre==""|| $apellido=="" || $usuario=="" || $clave1=="" || $clave2==""){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    
    ';
    exit();
}
#Verificando integridad de los datos
if(Verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre, )){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE no coincide con el fromato solicitado
        </div>
    
    ';
}

if (Verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido,)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El APELLIDO no coincide con el fromato solicitado
        </div>
    
    ';
}

if (Verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El USUARIO no coincide con el formato solicitado
        </div>
    
    ';
}

if (Verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || Verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES no coincide con el formato solicitado
        </div>
    
    ';
}

#Verificando el email
if($email!=""){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $check_email=conexion();
        $check_email=$check_email->query("SELECT usuario_email FROM usuarios WHERE usuario_email='$email'");
        if($check_email->rowCount()>0){
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                EL email ingresado ya se encuentra registrado, 
                por favor introduzca otro email 
            </div>
            ';
            exit();
        }

        $check_email=null;
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            EL email no es válido 
        </div>
    
    ';
    exit();

    }
}

#Verificando usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_usuario  FROM usuarios WHERE usuario_usuario='$usuario'");
if ($check_usuario->rowCount() > 0) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                EL USUARIO ingresado ya se encuentra registrado, 
                por favor introduzca otro usuario
            </div>
            ';
    exit();
}
$check_usuario=null;

#Verificando las claves
if($clave1!=$clave2){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las CLAVES que ha ingresado no coinciden
        </div>
        ';
    exit();
}else{
    $clave=password_hash($clave1, PASSWORD_BCRYPT, ["cost"=>10]);

}

#Guardando Datos
$guardar_usuario=conexion();
$guardar_usuario=$guardar_usuario->prepare("INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_usuario, usuario_email, usuario_clave) 
                                                        VALUES (:nombre, :apellido, :usuario, :email, :clave)");

$marcadores=[
    ":nombre"=>$nombre,
    ":apellido"=>$apellido,
    ":usuario" => $usuario,
    ":clave" => $clave,
    ":email" => $email
];
$guardar_usuario->execute($marcadores);

if($guardar_usuario->rowCount()==1){
    echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se registró con éxito
        </div>
    ';    
    
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el ususrio, por favor intente nuevamente
        </div>
    ';
}

$guardar_usuario=null;
?>