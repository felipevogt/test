<?php

include_once 'cliente/Cliente.php';
include_once 'response.php';

//Clase para llamar a las consultas sql
class ClienteController
{
    public $cliente;
    public $response;

    function __construct()
    {
        $this->cliente =  new Cliente();
        $this->response =  new Response();
    }

    function index($id)
    {
        $clientes = array();

        $res = $this->cliente->obtenerClientes($id);

        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {

                $item = array(
                    "id" => $row['id'],
                    "nombre" => $row['nombre'],
                    "apellido_paterno" => $row['apellido_paterno'],
                    "apellido_materno" => $row['apellido_materno'],
                    "correo" => $row['correo'],
                    "telefono" => $row['telefono'],
                );
                array_push($clientes, $item);
            }

            $this->response->success($clientes);
        } else {
            $this->response->error_406("No se encontro ningun elemento");
        }
    }

    function add($item)
    {
        $res = $this->cliente->nuevoCliente($item);
        $this->response->success("Cliente registrado");
    }

    function update($item)
    {
        $res = $this->cliente->editarCliente($item);
        if ($res->rowCount() == 1) {
            $this->response->success("Cliente editado");
        } else {
            $this->response->error_406("Cliente no encontrado");
        }
    }

    function delete($id)
    {
        $res = $this->cliente->eliminarCliente($id);

        if ($res->rowCount() == 1) {
            $this->response->success("Cliente eliminado");
        } else {
            $this->response->error_406("Cliente no encontrado");
        }
    }
}
