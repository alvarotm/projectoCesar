<?php

namespace app\models;
use core\Model;

class Peliculas extends Model{

    protected $table = 'peliculas';

    protected function getDirectores($id)
    {
        $directores = Model::belongsToMany("directores", "pelicula_director", "id_pelicula", "id_director", $id , "id"); 
        return $directores;
    }

    protected function getActores($id)
    {
        $actores = Model::belongsToMany("actores", "pelicula_actor", "id_pelicula", "id_actor", $id, "id");
        return $actores;
    }

    protected function getCriticas($id)
    {
        $criticas = Model::hasMany("criticas", "id_pelicula", $id);
        return $criticas;
    }

}