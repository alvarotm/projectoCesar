<?php

namespace app\controllers;
use core\Controller;

    class Main extends Controller{

        function notFound() {
            $data = NULL;
            $this->echoResponse(true, 404, $data);
        }

        function notAllowed() {
            $data = NULL;
            $this->echoResponse(true, 405, $data);
        }
}