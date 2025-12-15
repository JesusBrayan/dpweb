<?php
require_once("../library/conexion.php");
class VentaModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->connect();
    }


    //registral temporal
    public function registrar_temporal($id_producto,$precio, $cantidad){
        $consulta = "INSERT INTO temporal_venta (id_producto, precio, cantidad) 
        VALUES ('$id_producto', '$precio', '$cantidad')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            return $this->conexion->insert_id;
        }
        return 0;
    }


    //actualizar
    public function actualizarCantidadTemporal($id_producto, $cantidad){
        $consulta = "UPDATE temporal_venta SET cantidad='$cantidad' WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

    //actualizar by id
     public function actualizarCantidadTemporalByid($id_producto, $cantidad){
        $consulta = "UPDATE temporal_venta SET cantidad='$cantidad' WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }


    //buscar temporales
    public function buscarTemporales()
    {  
        $arr_temporal = array();
        $consulta = "SELECT tv.*, p.nombre FROM temporal_venta tv  INNER JOIN producto p ON tv.id_producto = p.id";
        $sql = $this->conexion->query($consulta);
        while ($objeto = $sql->fetch_object()) {
            array_push($arr_temporal, $objeto);
        }
        return $arr_temporal;
    }


    //buscar temporal
    public function buscarTemporal($id_producto)
    {
        $consulta = "SELECT * FROM temporal_venta 
        WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }


    //eliminar temporal
    public function eliminarTemporal($id)
    {
        $consulta = "DELETE FROM temporal_venta WHERE id='$id'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

    //eliminar temporal by id_producto
    public function eliminarTemporalByIdProducto($id_producto)
    {
        $consulta = "DELETE FROM temporal_venta WHERE id_producto='$id_producto'";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

    
    //eliminar temporales
     public function eliminarTemporales()
    {
        $consulta = "DELETE FROM temporal_venta";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }

//-------------------------------VENTAS REGISTRADAS (OFICIALES)-------------------------------------
    

//buscar ultima venta

    public function buscar_ultima_venta()
    {
        $consulta = "SELECT codigo FROM venta ORDER BY id DESC LIMIT 1";
        $sql = $this->conexion->query($consulta);
        return $sql->fetch_object();
    }
    public function registrar_venta($codigo, $id_cliente, $fecha_venta, $id_vendedor)
    {
        $consulta = "INSERT INTO venta (codigo, id_cliente, fecha_hora, id_vendedor) 
        VALUES ('$codigo', '$id_cliente', '$fecha_venta', '$id_vendedor')";
        $sql = $this->conexion->query($consulta);
        if ($sql) {
            return $this->conexion->insert_id;
        }
        return 0;
    }
    
    //registrar detalle venta
    public function registrar_detalle_venta($id_venta, $id_producto, $precio, $cantidad)
    {
        $consulta = "INSERT INTO detalle_venta (id_venta, id_producto, precio, cantidad) 
        VALUES ('$id_venta', '$id_producto', '$precio', '$cantidad')";
        $sql = $this->conexion->query($consulta);
        return $sql;
    }








}