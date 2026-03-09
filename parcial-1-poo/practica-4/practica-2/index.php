<?php

require_once "Usuario.php";
require_once "Admin.php";

$admin = new Admin("Carlos", "carlos@empresa.com");

echo "<h2>Datos del administrador</h2>";

echo "Nombre: " . $admin->getNombre() . "<br>";
echo "Correo: " . $admin->getCorreo() . "<br>";
echo "Rol: " . $admin->getRol() . "<br>";

?>