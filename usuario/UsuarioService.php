<?php

include_once 'usuario/UsuarioController.php';
include_once 'response.php';

//Clase para ejecutar verificar los metdoso de la request, verificar los datos y llamar a los controladores
class UsuarioService
{
    public $api;
    public $method;
    public $response;

    function __construct()
    {
        $this->api =  new UsuarioController();
        $this->response =  new Response();
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    function store()
    {
        try {
            if ($this->method == 'POST') {

                if (!empty($_POST)) {
                    $data = $_POST;
                } else {
                    $data = json_decode(file_get_contents('php://input'), true);
                }

                if (!empty($data['correo']) && !empty($data['password'])) {
                    $this->api->add([
                        'correo' => $data['correo'],
                        'password' => $data['password'],
                    ]);
                } else {
                    $this->response->error_400();
                }
            } else {
                $this->response->error_405();
            }
        } catch (\Throwable $th) {
            $this->response->error_500();
        }
    }

    function login()
    {
        if ($this->method == 'POST') {

            if (!empty($_POST)) {
                $data = $_POST;
            } else {
                $data = json_decode(file_get_contents('php://input'), true);
            }

            if (!empty($data['correo']) && !empty($data['password'])) {

                $this->api->login([
                    'correo' => $data['correo'],
                    'password' => $data['password'],
                ]);
            } else {
                $this->response->error_400();
            }
        } else {
            $this->response->error_405();
        }
    }

    function checkToken()
    {
        $headers = apache_request_headers();

        //verifica que el header contenga Authorization
        if (isset($headers['Authorization'])) {
            list($type, $data) = explode(" ", $headers["Authorization"], 2);

            //Verifica que sea de tipo Bearer
            if (strcasecmp($type, "Bearer") == 0) {

                $exist = $this->api->searchToken($data);

                //Verifica si el token existe
                if ($exist) {
                    $this->api->updateToken($exist);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
