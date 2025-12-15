<?php
require_once("../model/VentaModel.php");
require_once("../model/ProductoModel.php");
require_once("../model/UsuarioModel.php");

$objProducto = new ProductoModel();
$objVenta = new VentaModel();
// instancia para búsquedas de persona/usuario
$objPersona = new UsuarioModel();

$tipo = $_GET['tipo'];

if ($tipo == "registrar_temporal"){
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $id_producto = $_POST['id_producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $b_producto = $objVenta->buscarTemporal($id_producto);
    if ($b_producto){
        // Si ya existe, actualizar con la cantidad que viene del cliente
        $objVenta->actualizarCantidadTemporal($id_producto, $cantidad);
        $respuesta = array('status' => true, 'msg' => 'actualizado');

    }else{
        $registro = $objVenta->registrar_temporal($id_producto, $precio, $cantidad);
        $respuesta = array('status' => true, 'msg' => 'registrado');
    }
    echo json_encode($respuesta);
}


//listar productos en temporal
if($tipo == "listar_temporal"){
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $b_producto = $objVenta->buscarTemporales();
    if (!$b_producto){
        $b_producto = array('status' => true, 'data' => $b_producto);
    }else{
        $b_producto = array('status' => true, 'data' => $b_producto);
    }
    $respuesta = array('status' => true, 'data' => $b_producto);
    echo json_encode($respuesta);
}


if($tipo == "actualizar_cantidad"){
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $consulta = $objVenta->actualizarCantidadTemporalByid($id, $cantidad);
    if ($consulta){
        $respuesta = array('status' => true, 'msg' => 'success');
    }else{
        $respuesta = array('status' => false, 'msg' => 'error');
    }
    echo json_encode($respuesta);
    
}

if($tipo == "eliminar_temporal"){
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    $id_producto = $_POST['id_producto'];
    $consulta = $objVenta->eliminarTemporalByIdProducto($id_producto);
    if ($consulta){
        $respuesta = array('status' => true, 'msg' => 'eliminado');
    }else{
        $respuesta = array('status' => false, 'msg' => 'error al eliminar');
    }
    echo json_encode($respuesta);
}


//buscar cliente por dni
if ($tipo == "buscarCliente"){
    $dni = $_POST['dni'];
    $respuesta = array('status' => false, 'msg' => 'Cliente no encontrado');
    $cliente = $objPersona->buscarPersonaPornNroIdentidad($dni);
    if ($cliente){
        $respuesta = array('status' => true, 'data' => $cliente);
    }
    echo json_encode($respuesta);
}

if ($tipo == "usuario_sesion"){
    session_start();
    $respuesta = array('status' => false, 'msg' => 'No hay usuario en sesión');
    if (isset($_SESSION['ventas_id']) && !empty($_SESSION['ventas_id'])){
        $id_sesion = $_SESSION['ventas_id'];
        $usuario = $objPersona->obtenerUsuarioPorId($id_sesion);
        if ($usuario){
            $respuesta = array('status' => true, 'data' => $usuario);
        }
    }
    echo json_encode($respuesta);
}

if($tipo=="registrar_venta"){
    session_start();
    $cliente_dni = $_POST['cliente_dni'] ?? '';
    $cliente_nombre = $_POST['cliente_nombre'] ?? '';
    $fecha_venta = $_POST['fecha_venta'] ?? '';
    $id_vendedor = $_SESSION['ventas_id'] ?? null;
    
    $respuesta = array('status' => false, 'msg' => 'fallo el controlador');
    
    // Validar que el cliente exista por DNI
    $cliente = $objPersona->buscarPersonaPornNroIdentidad($cliente_dni);
    if (!$cliente) {
        $respuesta = array('status' => false, 'msg' => 'Cliente no encontrado');
        echo json_encode($respuesta);
        exit;
    }
    
    $id_cliente = $cliente->id;
    
    // Validar campos obligatorios
    if (empty($cliente_dni) || empty($fecha_venta) || empty($id_vendedor)) {
        $respuesta = array('status' => false, 'msg' => 'Faltan datos obligatorios');
        echo json_encode($respuesta);
        exit;
    }
    
    // Obtener correlativo
    $ultima_venta = $objVenta->buscar_ultima_venta();
    $correlativo = ($ultima_venta) ? $ultima_venta->codigo + 1 : 1;
    
    // Registrar la venta
    $venta = $objVenta->registrar_venta($correlativo, $id_cliente, $fecha_venta, $id_vendedor);
    if ($venta){
        // Registrar detalles de la venta
        $temporales = $objVenta->buscarTemporales();
        if ($temporales) {
            foreach ($temporales as $temporal){
                $objVenta->registrar_detalle_venta($venta, $temporal->id_producto, $temporal->precio, $temporal->cantidad);
            }
        }
        // Eliminar temporales
        $objVenta->eliminarTemporales();
        $respuesta = array('status' => true, 'msg' => 'Venta registrada con éxito');
    }else{
        $respuesta = array('status' => false, 'msg' => 'Error al registrar la venta en la base de datos');
    }

    echo json_encode($respuesta);
}