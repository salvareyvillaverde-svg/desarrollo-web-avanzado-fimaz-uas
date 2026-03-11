<?php

require_once "Usuario.php";

$Usuario = new Usuario("Maria", "maria@correo.com");
echo "<h2>Datos del usuario</h2>";

echo "Nombre: " . $Usuario->getNombre() . "<br>";
echo "Correo: " . $Usuario->getCorreo() . "<br>";
?> 