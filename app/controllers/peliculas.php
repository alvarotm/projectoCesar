<?php

namespace app\controllers;
use core\Controller;
use app\models\Peliculas as modelPelicula;

class peliculas extends Controller{

    public function getAll() {
        $data = NULL;
        $peliculas = modelPelicula::all();
        foreach($peliculas as $pelicula){
            $data[] = [
                "titulo" => $pelicula['titulo'],
                "anyo" => $pelicula['anyo'],
                "duracion" => $pelicula['duracion'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/peliculas/' . $pelicula['id']
                ]
            ];
        }

        $this->echoResponse(false, 200, $data);
    }

    public function getById($vars) {
        $data = NULL;
        $pelicula = modelPelicula::find($vars['id'])[0];

        if($pelicula !== NULL){
            $directores = $this->getDirectores($pelicula['id']);
            $actores = $this->getActores($pelicula['id']);
            $criticas = $this->getCriticas($pelicula['id']);
            $data = [
                "titulo" => $pelicula['titulo'],
                "anyo" => $pelicula['anyo'],
                "duracion" => $pelicula['duracion'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/peliculas/' . $pelicula['id']
                ],
                "embedded" => [
                    "directores" => $directores,
                    "actores" => $actores,
                    "criticas" => $criticas
                ]
            ];
            $this->echoResponse(false, 200, $data);
        } else {
            $this->echoResponse(true, 404, $data);
        }
    }

    protected function getDirectores($id){
        $data = array();
        $directores = modelPelicula::getDirectores($id);
        foreach($directores as $director){
            $data[] = [
                "nombre" => $director['nombre'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/director/' . $director['id']
                ]
            ];
        }
        return $data;
    }

    protected function getActores($id){
        $data = array();
        $actores = modelPelicula::getActores($id);
        foreach($actores as $actor){
            $data[] = [
                "nombre" => $actor['nombre'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/actor/' . $actor['id']
                ] 
            ];
        }
        return $data;
    }

    protected function getCriticas($id){
        $data = array();
        $criticas = modelPelicula::getCriticas($id);
        foreach($criticas as $critica){
            $data[] = [
                "medio" => $critica['medio'],
                "links" => [
                    "self" => $_ENV['APP_URL'] . '/criticas/' . $critica['id']
                ]
            ];
        }
        return $data;
    }

    public function criticas($vars) {
        $criticas = modelPelicula::getCriticas($vars['id']);
    }

}