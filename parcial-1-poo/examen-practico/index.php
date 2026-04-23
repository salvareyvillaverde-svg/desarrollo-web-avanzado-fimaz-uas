<?php

require_once "clases/Admin.php";
require_once "clases/Alumno.php";

$usuarios = [];

try{

    $admin = new Admin("Carlos López","admin@correo.com");
    $usuarios[] = $admin;

    $alumno = new Alumno("Ana Torres","alumno@correo.com","A12345");
    $usuarios[] = $alumno;

    // usuario con correo inválido
    $alumnoError = new Alumno("Pedro Ruiz","correo-invalido","A54321");
    $usuarios[] = $alumnoError;

}catch(Exception $e){

    $mensajeError = $e->getMessage();

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Usuarios</title>
</head>

<body>

<h2>Lista de Usuarios</h2>

<table border="1">

<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
</tr>

<?php

foreach($usuarios as $u){

    echo "<tr>";

    echo "<td>".$u->getNombre()."</td>";
    echo "<td>".$u->getCorreo()."</td>";
    echo "<td>".$u->getRol()."</td>";

    if($u instanceof Alumno){
        echo "<td>".$u->getMatricula()."</td>";
    }else{
        echo "<td>-</td>";
    }

    echo "</tr>";
}

?>

</table>

<?php
if(isset($mensajeError)){
    echo "<p style='color:red;'>Error detectado: $mensajeError</p>";
}
?>

</body>
</html>