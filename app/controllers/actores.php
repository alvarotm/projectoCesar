<?php

namespace app\controllers;
use core\Controller;
use app\models\Actores as modelActores;

class Actores extends Controller {

    public function getAll()
    {
        $data = null;
        $actores = modelActores::all();

        foreach($actores as $actor){
            $data[] = [
                "nombre" => $actor['nombre'],
                "anyo" => $actor['anyo'],
                "pais" => $actor['pais'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/actores/' . $actor['id']
                ]
            ];
        }
        $this->echoResponse(false, 200, $data);
    }

    public function getById($vars)
    {
        $actor = modelActores::find($vars['id'])[0];

        $data = null;

        if ($actor != null) {
            $data = [
                "nombre" => $actor['nombre'],
                "anyo" => $actor['anyo'],
                "pais" => $actor['pais'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/actor/' . $actor['id']
                ]
            ];
            $this->echoResponse(false, 200, 'esta bien');
        } else {
            $this->echoResponse(true, 404, 'esto esta mal');
        }

    }
}