<?php 

namespace Model;

class Categoria extends ActiveRecord {
    protected static $tabla = 'categorias';
    protected static $columnasDB = ['id_categoria', 'nombre'];
    protected static $idColumn = 'id_categoria';

    protected ?int $id_categoria = null;
    protected string $nombre = '';

    // Constructor
    public function __construct($args = [])
    {
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->nombre       = $args['nombre'] ?? '';
    }

    // Getters
    public function getIdCategoria(): ?int {
        return $this->id_categoria;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    // Setters
    public function setIdCategoria(?int $id): void {
        $this->id_categoria = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    // Validación
    public function validar() {
        self::$alertas = [];

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        return self::$alertas;
    }
}
