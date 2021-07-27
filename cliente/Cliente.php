<?php

include_once 'db.php';

//Clase para ejecutar las consultas sql
class Cliente extends DB
{

    function obtenerClientes($id)
    {
        $query = $this->connect()->query('SELECT * FROM cliente WHERE id_usuario=' . $id);
        return $query;
    }

    function nuevoCliente($cliente)
    {
        $query = $this->connect()->prepare('INSERT INTO cliente (nombre, apellido_paterno, apellido_materno, correo, telefono, id_usuario) VALUES (:nombre, :apellido_paterno, :apellido_materno, :correo, :telefono, :id_usuario)');
        $query->execute([
            'nombre' => $cliente['nombre'],
            'apellido_paterno' => $cliente['apellido_paterno'],
            'apellido_materno' => $cliente['apellido_materno'],
            'correo' => $cliente['correo'],
            'telefono' => $cliente['telefono'],
            'id_usuario' => $cliente['id_usuario']
        ]);
        return $query;
    }

    function editarCliente($cliente)
    {
        $query = $this->connect()->prepare('UPDATE cliente SET nombre=:nombre, apellido_paterno=:apellido_paterno, apellido_materno=:apellido_materno, correo=:correo, telefono=:telefono WHERE id=:id');
        $query->execute([
            'id' => $cliente['id'],
            'nombre' => $cliente['nombre'],
            'apellido_paterno' => $cliente['apellido_paterno'],
            'apellido_materno' => $cliente['apellido_materno'],
            'correo' => $cliente['correo'],
            'telefono' => $cliente['telefono']
        ]);
        return $query;
    }

    function eliminarCliente($id)
    {
        $query = $this->connect()->query('DELETE FROM cliente WHERE id=' . $id);
        return $query;
    }
}
