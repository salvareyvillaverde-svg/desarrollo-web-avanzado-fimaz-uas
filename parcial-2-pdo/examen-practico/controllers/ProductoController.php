<?php
namespace Controllers;

use Config\Database;
use Models\Producto;
use PDO;
use PDOException;

class ProductoController
{
    private PDO $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function crear(Producto $producto): bool
    {
        try {
            $sql = "INSERT INTO productos (nombre, descripcion, existencia, precio)
                    VALUES (:nombre, :descripcion, :existencia, :precio)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error al crear producto: ' . $e->getMessage());
        }
    }

    public function listar(): array
    {
        try {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException('Error al listar productos: ' . $e->getMessage());
        }
    }

    public function obtenerPorId(int $id): array|false
    {
        try {
            $sql = "SELECT * FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new PDOException('Error al obtener producto: ' . $e->getMessage());
        }
    }

    public function actualizar(Producto $producto): bool
    {
        try {
            $sql = "UPDATE productos 
                    SET nombre = :nombre,
                        descripcion = :descripcion,
                        existencia = :existencia,
                        precio = :precio
                    WHERE id = :id";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $producto->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':existencia', $producto->getExistencia(), PDO::PARAM_INT);
            $stmt->bindValue(':precio', $producto->getPrecio());

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error al actualizar producto: ' . $e->getMessage());
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $sql = "DELETE FROM productos WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Error al eliminar producto: ' . $e->getMessage());
        }
    }

    public function buscar(string $termino): array
    {
        try {
            $sql = "SELECT * FROM productos
                    WHERE nombre LIKE :termino
                    OR descripcion LIKE :termino
                    ORDER BY id DESC";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':termino', '%' . $termino . '%');
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException('Error al buscar productos: ' . $e->getMessage());
        }
    }
}