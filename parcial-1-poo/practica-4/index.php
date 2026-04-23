<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "clases/Usuario.php";
require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";

$usuarios = [];

try {

    $admin = new Admin("Carlos", "carlos@correo.com");
    $alumno = new Alumno("Ana", "ana@correo.com", "A123");
    $invitado = new Invitado("Luis", "luis@empresa.com", "Microsoft");

    $usuarios[] = $admin;
    $usuarios[] = $alumno;
    $usuarios[] = $invitado;

    // correo inválido para probar excepción
    $error = new Admin("Pedro", "correo-mal");

} catch (Exception $e) {

    echo "<h3>Error controlado: " . $e->getMessage() . "</h3>";

}

echo "<h2>Lista de Usuarios</h2>";

echo "<table border='1' cellpadding='5'>";
echo "<tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Matrícula</th>
        <th>Empresa</th>
      </tr>";

foreach ($usuarios as $u) {

    $matricula = method_exists($u, "getMatricula") ? $u->getMatricula() : "—";
    $empresa = method_exists($u, "getEmpresa") ? $u->getEmpresa() : "—";

    echo "<tr>";
    echo "<td>" . $u->getNombre() . "</td>";
    echo "<td>" . $u->getCorreo() . "</td>";
    echo "<td>" . $u->getRol() . "</td>";
    echo "<td>" . $matricula . "</td>";
    echo "<td>" . $empresa . "</td>";
    echo "</tr>";
}

echo "</table>";

