<?php

/** Clase encargada de las respuestas de la api */
class Response
{

    public $response = [
        'status' => "ok",
        'result' => array(),
    ];

    function success($data)
    {
        $this->response['result'] = $data;
        echo json_encode($this->response);
    }

    public function error_400()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Datos enviados incompletos"
        );
        echo json_encode($this->response);
    }

    public function error_404()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "404",
            "error_msg" => "Sitio no encontrado"
        );
        echo json_encode($this->response);
    }

    public function error_405()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Metodo no permitido"
        );
        echo json_encode($this->response);
    }

    public function error_406($valor = "No se encontro el contenido")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "406",
            "error_msg" =>  $valor
        );
        echo json_encode($this->response);
    }

    public function error_200($valor = "Datos incorrectos")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $valor
        );
        echo json_encode($this->response);
    }

    public function error_500($valor = "Error interno del servidor")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $valor
        );
        echo json_encode($this->response);
    }
}
