<?php

include_once 'usuario/UsuarioService.php';
include_once 'cliente/ClienteService.php';
include_once 'response.php';

class Router
{
    public $usuario_service;
    public $cliente_service;
    public $response;
    public $URL;

    function __construct()
    {
        $this->usuario_service =  new UsuarioService();
        $this->cliente_service = new ClienteService();
        $this->response = new Response();
        $this->URL = "/felipe_vogt/";
    }

    /** Encargado de dirigir las rutas de la api */
    function routes($request)
    {
        $re = '/\/felipe_vogt\/clientes\/[0-9]+/';

        switch ($request) {
            case $this->URL . 'agregarCliente':
                $this->navigate($this->cliente_service, "store", true);
                break;
            case (preg_match($re, $request) == 1):
                //Acepta solo /clientes/[numero]
                $_GET["id"] = str_replace($this->URL . 'clientes/', "", $request);
                $this->navigate($this->cliente_service, "index", true);
                break;
            case $this->URL . 'editarCliente':
                $this->navigate($this->cliente_service, "update", true);
                break;
            case $this->URL . 'eliminarCliente':
                $this->navigate($this->cliente_service, "delete", true);
                break;
            case $this->URL . 'registrar':
                $this->navigate($this->usuario_service, "store");
                break;
            case $this->URL . 'login':
                $this->navigate($this->usuario_service, "login");
                break;
            default:
                $this->response->error_404();
                break;
        }
    }

    /** Se encarga de ejecutar metodos de clases */
    function navigate($class, $route, $protected = false)
    {
        if ($protected) {
            if ($this->usuario_service->checkToken()) {
                call_user_func(array($class, $route));
            } else {
                echo json_encode(array('mensaje' => 'No autorizado'));
            }
        } else {
            call_user_func(array($class, $route));
        }
    }
}
