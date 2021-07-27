<?php

include_once 'cliente/ClienteController.php';

//Clase para ejecutar verificar los metdoso de la request, verificar los datos y llamar a los controladores
class ClienteService
{
    public $api;
    public $method;
    public $response;

    function __construct()
    {
        $this->api =  new ClienteController();
        $this->response =  new Response();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    function index()
    {
        if ($this->method == 'GET') {
            if (isset($_GET['id'])) {
                $this->api->index($_GET['id']);
            } else {
                $this->response->error_400();
            }
        } else {
            $this->response->error_405();
        }
    }

    function store()
    {
        $campos = ['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'id_usuario'];
        $errors = [];
        $values = [];

        if (!empty($_POST)) {
            $data = $_POST;
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
        }


        if ($this->method == 'POST') {

            //Recorres los campos de POST y verifica que no esten vacios
            foreach ($campos as $campo) {
                if (empty($data[$campo])) {
                    $errors[] = $campo;
                } else {
                    $values[$campo] = $data[$campo];
                }
            }

            //Verifica si el array de errors esta vacio
            if (empty($errors)) {
                $this->api->add($values);
            } else {
                $this->response->error_400();
            }
        } else {
            $this->response->error_405();
        }
    }

    function update()
    {
        $campos = ['id', 'nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono'];
        $errors = [];
        $values = [];

        if (!empty($_POST)) {
            $data = $_POST;
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
        }



        if ($this->method == 'POST') {
            //Recorres los campos de POST y verifica que no esten vacios
            foreach ($campos as $campo) {
                if (empty($data[$campo])) {
                    $errors[] = $campo;
                } else {
                    $values[$campo] = $data[$campo];
                }
            }

            //Verifica si el array de errors esta vacio
            if (empty($errors)) {
                $this->api->update($values);
            } else {
                $this->response->error_400();
            }
        } else {
            $this->response->error_405();
        }
    }

    function delete()
    {
        if ($this->method == 'POST') {

            if (!empty($_POST)) {
                $data = $_POST;
            } else {
                $data = json_decode(file_get_contents('php://input'), true);
            }

            if (!empty($data['id'])) {
                $this->api->delete($data['id']);
            } else {
                $this->response->error_400();
            }
        } else {
            $this->response->error_405();
        }
    }
}
