<?php
// Estudiante: Salvador Reynoso

spl_autoload_register(function ($clase) {
    $partes = explode('\\', $clase);

    if (!empty($partes[0])) {
        $partes[0] = strtolower($partes[0]); // Config -> config, Models -> models, Controllers -> controllers
    }

    $ruta = __DIR__ . '/' . implode('/', $partes) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
    }
});