<?php

namespace app\controllers;
use core\Controller;
use app\models\Directores as modelDirectores;

class Directores extends Controller {

    function getAll()
    {
        $data = null;
        $directores = modelDirectores::all();
        foreach($directores as $director){
            $data[] = [
                "nombre" => $director['nombre'],
                "anyo" => $director['anyo'],
                "pais" => $director['pais'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/director/' . $director['id']
                ]
                ];
        }

        $this->echoResponse(false, 200, $data);
    }

    function getById($vars){
        $director = modelDirectores::find($vars['id'])[0];
        $data = null;
        if($director != null){
            $data = [
                "nombre" => $director['nombre'],
                "anyo" => $director['anyo'],
                "pais" => $director['pais'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/director/' . $director['id']
                ]
                ];
                $this->echoResponse(false,200,$data);
        }

    }
}