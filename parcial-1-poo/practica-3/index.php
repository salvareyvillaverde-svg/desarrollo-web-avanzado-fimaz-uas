<?php

require_once "clases/Admin.php";
require_once "clases/Alumno.php";

try {

    $admin = new Admin("Carlos", "carlos@empresa.com");
    $alumno = new Alumno("Ana", "ana@correo.com", "A123");

    echo "<h2>Usuarios válidos</h2>";

    echo $admin->getNombre() . " - " . $admin->getRol() . "<br>";
    echo $alumno->getNombre() . " - " . $alumno->getRol() . "<br>";

    // usuario inválido
    $error = new Admin("Pedro", "correo-mal");

} catch (Exception $e) {

    echo "<h3>Error detectado:</h3>";
    echo $e->getMessage();

}