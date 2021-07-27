<?php

include_once 'usuario/Usuario.php';
include_once 'response.php';

//Clase para llamar a las consultas sql
class UsuarioController
{
    public $usuario;
    public $response;

    function __construct()
    {
        $this->usuario =  new Usuario();
        $this->response =  new Response();
    }

    function add($item)
    {
        $res = $this->usuario->nuevoUsuario($item);
        $this->response->success('Usuario registrado');
    }

    function login($item)
    {
        $res = $this->usuario->obtenerUsuario($item);

        //verifica si existe respuesta
        if ($res->rowCount() == 1) {
            $row = $res->fetch();

            $user = array(
                "id" => $row['id'],
                "correo" => $row['correo'],
                "password" => $row['password'],
            );

            //verifica si las contraseñas son iguales
            if (password_verify($item['password'], $user['password'])) {
                $token = $this->addToken($user['id']);

                //Verifica si se creo el token
                if ($token) {
                    $data = array(
                        "id" => $user['id'],
                        "correo" => $user['correo'],
                        "token" => $token,
                    );
                    $this->response->success($data);
                } else {
                    $this->response->error_500();
                }
            } else {
                $this->response->error_200();
            }
        } else {
            $this->response->error_406("Usuario no encontrado");
        }
    }

    /** Metodo para crear token */
    function addToken($id)
    {
        $val = true;
        $data = array(
            "token" => bin2hex(openssl_random_pseudo_bytes(16, $val)),
            "fecha" => date("Y-m-d H:i"),
            "estado" => 1,
            "id_usuario" => $id,
        );

        $res = $this->usuario->crearToken($data);

        if ($res->rowCount() == 1) {
            return $data['token'];
        } else {
            return false;
        }
    }

    /** Metodo para buscar token */
    function searchToken($token)
    {
        $res = $this->usuario->buscarToken($token);

        if ($res->rowCount() == 1) {
            $row = $res->fetch();
            return $row['id'];
        } else {
            return false;
        }
    }

     /** Metodo para actualizar una token */
    function updateToken($id)
    {
        $data = array(
            "id" => $id,
            "fecha" => date("Y-m-d H:i"),
        );

        $res = $this->usuario->actualizarToken($data);

        if ($res->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
