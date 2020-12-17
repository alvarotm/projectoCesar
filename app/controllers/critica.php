<?php

namespace app\controllers;
use core\Controller;
use app\models\Peliculas as modelPeliculas;
use app\models\Criticas as modelCriticas;

class Critica extends Controller{

    public function getAll()
    {
        $data = NULL;
        $criticas = modelCriticas::all();
        foreach ($criticas as $critica) {
            $data[] = [
                "medio" => $critica['medio'],
                "puntuacion" => $critica['puntuacion'],
                "critica" => $critica['critica'],
                "links" => [
                    "pelicula" => $_ENV['APP_URL'] . '/peliculas/' . $critica['id_pelicula'],
                    "self" => $_ENV['APP_URL'] . '/criticas/' . $critica['id']
                ]
            ];
        }

        $this->echoResponse(false, 200, $data);
    }


    public function getById($vars)
    {
        $critica = modelCriticas::find($vars['id'])[0];
        $data = null;
        if ($critica != null) {
            $data = [
                "medio" => $critica['medio'],
                "puntuacion" => $critica['puntuacion'],
                "critica" => $critica['critica'],
                "links" => [
                    "pelicula" => $_ENV['APP_URL'] . '/peliculas/' . $critica['id_pelicula'],
                    "self" => $_ENV['APP_URL'] . '/criticas/' . $critica['id']
                ]
            ];
            $this->echoResponse(false, 200, $data);
        } else {
            $this->echoResponse(true, 404, $data);
        }
    }

    public function insert()
    {
        $postContent = json_decode(file_get_contents("php://input"));
        

        modelCriticas::insert($postContent);
        $idCritica = strval(modelCriticas::lastID()['id']);
        $data = [
            "links" => [
                "self" => $_ENV['APP_URL'] . '/criticas/' . $idCritica
            ]
        ];
        $this->echoResponse(false, 200, $data);
    }


    public function edit($vars)
    {
        $critica = modelCriticas::find($vars['id_critica']);
        if ($critica != null) {
            $postContent = json_decode(file_get_contents("php://input"));
            $data = [
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/criticas/' . $vars['id_critica']
                ]
            ];
            modelCriticas::edit($vars['id_critica'], $postContent);
            $this->echoResponse(false, 200, $data);
        } else {
            $this->echoResponse(true, 404);
        }
    }

    public function delete($vars){
        $data = modelCriticas::find($vars['id_critica']);
        modelCriticas::delete($vars['id_critica']);
        $this->echoResponse(false, 200, $data);
    }
        
}