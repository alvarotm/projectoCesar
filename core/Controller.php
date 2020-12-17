<?php

namespace core;

use League\Plates\Engine as PlatesEngine;

class Controller {

    protected $messages = [
        "200" => "OK",
        "400" => "Peticion no correcta",
        "401" => "No hay permisos",
        "404" => "No encontrado",
        "405" => "No permitido"
    ];

    protected function echoResponse($error, $status_code, $data = null){
        $response['error'] = $error;
        $response['message'] = $this->messages[$status_code];
        $response['data'] = $data;
        \http_response_code($status_code);
        exit(\json_encode($response));
    }

}
