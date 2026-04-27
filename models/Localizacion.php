<?php 

namespace Model;

class Localizacion extends ActiveRecord {
    protected static $tabla = 'localizaciones';
    protected static $columnasDB = ['id_localizacion', 'nombre', 'direccion', 'coordenadas'];
    protected static $idColumn = 'id_localizacion';

    // Atributos encapsulados
    protected ?int $id_localizacion = null;
    protected string $nombre = '';
    protected string $direccion = '';
    protected string $coordenadas = '';

    // Constructor
    public function __construct($args = [])
    {
        $this->id_localizacion = $args['id_localizaciones'] ?? null;
        $this->nombre          = trim($args['nombre'] ?? '');
        $this->direccion       = trim($args['direccion'] ?? '');
        $this->coordenadas     = trim($args['coordenadas'] ?? '');
    }

    // Getters

    public function getIdLocalizacion(): ?int {
        return $this->id_localizacion;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function getCoordenadas(): string {
        return $this->coordenadas;
    }

    // Setters
    public function setIdLocalizacion(?int $id): void {
        $this->id_localizacion = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function setCoordenadas(string $coordenadas): void {
        $this->coordenadas = $coordenadas;
    }

    // Validación
    public function validar() {
        self::$alertas = []; // Reiniciamos alertas

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->direccion) {
            self::$alertas['error'][] = 'La dirección es obligatoria';
        }

        if(!$this->coordenadas) {
            self::$alertas['error'][] = 'Las coordenadas son obligatorias';
        } else {
            // Validar formato de coordenadas (ej: "43.3614,-5.8593")
            $pattern = '/^-?\d{1,3}\.\d+,\s?-?\d{1,3}\.\d+$/';
            if(!preg_match($pattern, $this->coordenadas)) {
                self::$alertas['error'][] = 'Las coordenadas deben tener el formato "latitud,longitud" (por ejemplo: 43.3614,-5.8593)';
            }
        }

        return self::$alertas;
    }
}
