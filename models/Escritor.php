<?php 

namespace Model;

class Escritor extends ActiveRecord {
    protected static $tabla = 'escritores';
    protected static $columnasDB = ['id_escritor', 'nombre', 'biografia', 'nacionalidad', 'imagen'];
    protected static $idColumn = 'id_escritor';

    // Atributos encapsulados
    protected ?int $id_escritor = null;
    protected string $nombre = '';
    protected string $biografia = '';
    protected string $nacionalidad = '';
    protected string $imagen = '';

    // Para evitar que se tiña de rojo en el controlador cuando se usa
    public ?string $imagen_actual = null;

    // Constructor
    public function __construct($args = [])
    {
        $this->id_escritor = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->biografia = $args['biografia'] ?? '';
        $this->nacionalidad = $args['nacionalidad'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->imagen_actual = $args['imagen_actual'] ?? null;
    }

    // Getters

    public function getIdEscritor(): ?int {
        return $this->id_escritor;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getBiografia(): string {
        return $this->biografia;
    }

    public function getNacionalidad(): string {
        return $this->nacionalidad;
    }

    public function getImagen(): string {
        return $this->imagen;
    }

    public function getImagenActual(): ?string {
        return $this->imagen_actual;
    }

    // Setters

    public function setIdEscritor(?int $id): void {
        $this->id_escritor = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setBiografia(string $biografia): void {
        $this->biografia = $biografia;
    }

    public function setNacionalidad(string $nacionalidad): void {
        $this->nacionalidad = $nacionalidad;
    }

    public function setImagen(string $imagen): void {
        $this->imagen = $imagen;
    }

    public function setImagenActual(?string $imagenActual): void {
        $this->imagen_actual = $imagenActual;
    }

    // Validación
    public function validar() {
        self::$alertas = [];

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->biografia) {
            self::$alertas['error'][] = 'La biografía es obligatoria';
        }
        if(!$this->nacionalidad) {
            self::$alertas['error'][] = 'La nacionalidad es obligatoria';
        }
        if(!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
    
        return self::$alertas;
    }
}
