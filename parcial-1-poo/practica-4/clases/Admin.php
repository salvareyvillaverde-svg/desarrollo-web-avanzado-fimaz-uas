<?php

require_once "Usuario.php";

class Admin extends Usuario {

    public function __construct($nombre, $correo) {
        parent::__construct($nombre, $correo);
    }

    public function getRol() {
        return "Administrador";
    }

}