<?php
// Estudiante: Salvador Reynoso
date_default_timezone_set('America/Mazatlan');

require_once 'autoload.php';

use Controllers\ProductoController;
use Models\Producto;

$controller = new ProductoController();

$mensaje = '';
$tipoMensaje = 'info';
$productoEditar = null;
$terminoBusqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// ELIMINAR
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $idEliminar = (int) $_GET['eliminar'];

    try {
        if ($controller->eliminar($idEliminar)) {
            $mensaje = 'Producto eliminado correctamente.';
            $tipoMensaje = 'success';
        } else {
            $mensaje = 'No se pudo eliminar el producto.';
            $tipoMensaje = 'danger';
        }
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        $tipoMensaje = 'danger';
    }
}

// EDITAR
if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
    $idEditar = (int) $_GET['editar'];

    try {
        $productoEditar = $controller->obtenerPorId($idEditar);
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        $tipoMensaje = 'danger';
    }
}

// GUARDAR O ACTUALIZAR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = !empty($_POST['id']) ? (int) $_POST['id'] : null;
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $existencia = isset($_POST['existencia']) ? (int) $_POST['existencia'] : 0;
    $precio = isset($_POST['precio']) ? (float) $_POST['precio'] : 0;

    if ($nombre === '' || $descripcion === '') {
        $mensaje = 'Nombre y descripción son obligatorios.';
        $tipoMensaje = 'warning';
    } elseif ($existencia < 0 || $precio < 0) {
        $mensaje = 'Existencia y precio no pueden ser negativos.';
        $tipoMensaje = 'warning';
    } else {
        $producto = new Producto();
        $producto->setId($id);
        $producto->setNombre($nombre);
        $producto->setDescripcion($descripcion);
        $producto->setExistencia($existencia);
        $producto->setPrecio($precio);

        try {
            if ($id) {
                if ($controller->actualizar($producto)) {
                    $mensaje = 'Producto actualizado correctamente.';
                    $tipoMensaje = 'success';
                    $productoEditar = null;
                } else {
                    $mensaje = 'Error al actualizar el producto.';
                    $tipoMensaje = 'danger';
                }
            } else {
                if ($controller->crear($producto)) {
                    $mensaje = 'Producto agregado correctamente.';
                    $tipoMensaje = 'success';
                } else {
                    $mensaje = 'Error al agregar el producto.';
                    $tipoMensaje = 'danger';
                }
            }
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $tipoMensaje = 'danger';
        }
    }
}

// LISTAR O BUSCAR
try {
    if ($terminoBusqueda !== '') {
        $productos = $controller->buscar($terminoBusqueda);
    } else {
        $productos = $controller->listar();
    }
} catch (Exception $e) {
    $mensaje = $e->getMessage();
    $tipoMensaje = 'danger';
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos con PHP, PDO y POO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">

    <h2 class="text-center mb-4">CRUD de Productos con PHP, PDO y POO</h2>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($tipoMensaje); ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?php echo $productoEditar ? 'Editar producto' : 'Agregar producto'; ?>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($productoEditar['id'] ?? ''); ?>">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nombre</label>
                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            value="<?php echo htmlspecialchars($productoEditar['nombre'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Descripción</label>
                        <input
                            type="text"
                            name="descripcion"
                            class="form-control"
                            value="<?php echo htmlspecialchars($productoEditar['descripcion'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Existencia</label>
                        <input
                            type="number"
                            name="existencia"
                            class="form-control"
                            value="<?php echo htmlspecialchars($productoEditar['existencia'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Precio</label>
                        <input
                            type="number"
                            step="0.01"
                            name="precio"
                            class="form-control"
                            value="<?php echo htmlspecialchars($productoEditar['precio'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <?php echo $productoEditar ? 'Actualizar' : 'Guardar'; ?>
                        </button>
                    </div>
                </div>

                <?php if ($productoEditar): ?>
                    <a href="index.php" class="btn btn-secondary">Cancelar edición</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Lista de productos
        </div>

        <div class="card-body">
            <form method="GET" action="" class="row g-2 mb-3">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar por nombre o descripción"
                        value="<?php echo htmlspecialchars($terminoBusqueda); ?>"
                    >
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>

                <?php if ($terminoBusqueda !== ''): ?>
                    <div class="col-12">
                        <a href="index.php" class="btn btn-secondary btn-sm">Mostrar todos</a>
                    </div>
                <?php endif; ?>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Existencia</th>
                        <th>Precio</th>
                        <th width="180">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($productos) > 0): ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td><?php echo htmlspecialchars($producto['existencia']); ?></td>
                                <td>$<?php echo number_format((float)$producto['precio'], 2); ?></td>
                                <td>
                                    <a href="index.php?editar=<?php echo $producto['id']; ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>
                                    <a
                                        href="index.php?eliminar=<?php echo $producto['id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que deseas eliminar este producto?');"
                                    >
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay productos registrados.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>