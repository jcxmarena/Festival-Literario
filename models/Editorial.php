<?php 

namespace Model;

class Editorial extends ActiveRecord {

    protected static $tabla = 'editoriales';
    protected static $columnasDB = ['id_editorial', 'nombre', 'pais', 'anio_fundacion'];
    protected static $idColumn = 'id_editorial';

    // Atributos encapsulados
    protected ?int $id_editorial = null;
    protected string $nombre = '';
    protected string $pais = '';
    protected ?int $anio_fundacion = null;

    // Constructor
    public function __construct($args = [])
    {
        $this->id_editorial = $args['id_editorial'] ?? null;
        $this->nombre = trim($args['nombre'] ?? '');
        $this->pais   = trim($args['pais'] ?? '');
        $this->anio_fundacion = $args['anio_fundacion'] ?? null;
    }

    //Getters

    public function getIdEditorial(): ?int {
        return $this->id_editorial;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getPais(): string {
        return $this->pais;
    }

    public function getAnioFundacion(): ?int {
        return $this->anio_fundacion;
    }

    // Setters

    public function setIdEditorial(?int $id): void {
        $this->id_editorial = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = trim($nombre);
    }

    public function setPais(string $pais): void {
        $this->pais = trim($pais);
    }

    public function setAnioFundacion(?int $anio): void {
        $this->anio_fundacion = $anio;
    }

    // Validación
    public function validar() {
        self::$alertas = [];

        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->pais) {
            self::$alertas['error'][] = 'El país es obligatorio';
        }

        // El año de fundación es opcional pero si se da debe ser un número válido
        if ($this->anio_fundacion !== null && !is_numeric((string)$this->anio_fundacion)) {
            self::$alertas['error'][] = 'El año de fundación debe ser un número';
        }

        return self::$alertas;
    }
}
