<?php
namespace Models;

class Producto
{
    private ?int $id = null;
    private string $nombre = '';
    private string $descripcion = '';
    private int $existencia = 0;
    private float $precio = 0;

    public function __construct(
        ?int $id = null,
        string $nombre = '',
        string $descripcion = '',
        int $existencia = 0,
        float $precio = 0
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->existencia = $existencia;
        $this->precio = $precio;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getExistencia(): int
    {
        return $this->existencia;
    }

    public function setExistencia(int $existencia): void
    {
        $this->existencia = $existencia;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }
}