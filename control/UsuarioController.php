<?php
require_once("../model/UsuarioModel.php");
$objPersona = new UsuarioModel();
$tipo = $_GET['tipo'];


if ($tipo == 'registrar') {

//print_r($_POST);
    $nro_identidad = $_POST['nro_identidad'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $cod_postal = $_POST['cod_postal'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];
    //Encriptando nro_documento para utilizarlo como contraseña
    $password = password_hash($nro_identidad, PASSWORD_DEFAULT);

    if ($nro_identidad == "" || $razon_social == "" || $telefono == "" || $correo == "" || $departamento == "" || $provincia == "" || $distrito == "" || $cod_postal == "" || $direccion == "" || $rol == "") {

        $arrResponse = array('status' => false, 'msg' => 'Error,campos vacios');
    } else {
        //Validacion si existe Persona con el mismo dni
        $existePersona = $objPersona->existePersona($nro_identidad);
        if ($existePersona > 0) {
            $arrResponse = array('status' => false, 'msg' => 'Error,nro de documento ya existe');
        } else {
            $respuesta = $objPersona->registrar($nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol, $password);
            if ($respuesta) {
                $arrResponse = array('status' => true, 'msg' => 'Registrado Correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error,falló en registro');
            }
        }
    }
    echo json_encode($arrResponse);
}
if ($tipo == "iniciar_sesion") {
    $nro_identidad = $_POST['usuario'];
    $password = $_POST['password'];
    if ($nro_identidad == "" || $password == "") {
        $respuesta = array('status' => false, 'msg' =>
        'Error, campos vacios');
    } else {
        $existePersona = $objPersona->existePersona($nro_identidad);
        if (!$existePersona) {
            $respuesta = array('status' => false, 'msg' =>
            'Error, usuario no existe');
        } else {
            $persona = $objPersona->buscarPersonaPornNroIdentidad($nro_identidad);
            if (password_verify($password, $persona->password)) {
                session_start();
                $_SESSION['ventas_id'] = $persona->id;
                $_SESSION['ventas_usuario'] = $persona->razon_social;
                $respuesta = array('status' => true, 'msg' => 'ok');
            } else {
                $respuesta = array('status' => false, 'msg' => 'Error, contraseña incorrecta');
            }
        }
    }
    echo json_encode($respuesta);
}


//ver usuarios
if ($tipo == "ver_usuarios") {
    $usuarios = $objPersona->verUsuarios();
    echo json_encode($usuarios);
}


// Ver usuario
if ($tipo == "ver") {
    //print_r($_POST);
    $respuesta = array('status' => false, 'msg' => 'Error');
    $id_persona = $_POST['id_persona'];
    $usuario = $objPersona->ver($id_persona);
    if ($usuario) {
        $respuesta['status'] = true;
        $respuesta['data'] = $usuario;
    } else {
        $respuesta['msg'] = 'Error, usuario no existe';
    }
    echo json_encode($respuesta);
}


// Actualizar
if ($tipo == "actualizar") {
    //print_r($_POST);
    $id_persona = $_POST['id_persona'];
    $nro_identidad = $_POST['nro_identidad'];
    $razon_social = $_POST['razon_social'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $departamento = $_POST['departamento'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $cod_postal = $_POST['cod_postal'];
    $direccion = $_POST['direccion'];
    $rol = $_POST['rol'];
    if ($id_persona == "" || $nro_identidad == "" || $razon_social == "" || $telefono == "" || $correo == "" || $departamento == "" || $provincia == "" || $distrito == "" || $cod_postal == "" || $direccion == "" || $rol == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error,campos vacios');
    } else {
        $existeID = $objPersona->ver($id_persona);
        if (!$existeID) {
            //devolver msm
            $arrResponse = array('status' => false, 'msg' => 'Error, usuario, no existe en BD');
            echo json_encode($arrResponse);
            //cerrar funcion
            exit;
        } else {
            //actualizar
            $actualizar = $objPersona->actualizar($id_persona, $nro_identidad, $razon_social, $telefono, $correo, $departamento, $provincia, $distrito, $cod_postal, $direccion, $rol);
            if ($actualizar) {
                $arrResponse = array('status' => true, 'msg' => "actualizado correctamente");
            } else {
                $arrResponse = array('status' => false, 'msg' => $actualizar);
            }
            echo json_encode($arrResponse);
            exit;
        }
    }
}


// ELIMINAR
if ($tipo == "eliminar") {

    $id_persona = isset($_POST['id']) ? $_POST['id'] : '';

    if ($id_persona == "") {
        $arrResponse = array('status' => false, 'msg' => 'Error, ID vacío');
    } else {
        $existeId = $objPersona->ver($id_persona);
        if (!$existeId) {
            $arrResponse = array('status' => false, 'msg' => 'Error, usuario no existe en Base de Datos!!');
        } else {
            $eliminar = $objPersona->eliminar($id_persona);
            if ($eliminar) {
                $arrResponse = array('status' => true, 'msg' => "Eliminado correctamente");
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
            }
        }
    }
    echo json_encode($arrResponse);
    exit;
}

// Ver clientes
if ($tipo == "ver_clients") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $usuarios = $objPersona->verClientes();
    if (count($usuarios)) {
        $respuesta = array('status' => true, 'msg' => '', 'data' => $usuarios);
    }
    echo json_encode($respuesta);
}

// Ver proveedores
if ($tipo == "ver_proveedores") {
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $usuarios = $objPersona->verProveedores();
    if (count($usuarios)) {
        $respuesta = array('status' => true, 'msg' => '', 'data' => $usuarios);
    }
    echo json_encode($respuesta);
}
