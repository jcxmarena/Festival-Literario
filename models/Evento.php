<?php 

namespace Model;

class Evento extends ActiveRecord {
    protected static $tabla = 'eventos';
    protected static $columnasDB = [
        'id_evento', 
        'titulo', 
        'descripcion', 
        'id_categoria', 
        'id_escritor', 
        'id_localizacion', 
        'fecha'
    ];
    protected static $idColumn = 'id_evento';

    // Atributos encapsulados
    protected ?int $id_evento = null;
    protected string $titulo = '';
    protected string $descripcion = '';
    protected ?int $id_categoria = null;
    protected ?int $id_escritor = null;
    protected ?int $id_localizacion = null;
    protected string $fecha = ''; // DATETIME (Y-m-d H:i:s)

    // Para evitar que se tiñan de rojo en el controlador
    public ?Categoria $categoria = null;
    public ?Escritor $escritor = null;
    public ?Localizacion $localizacion = null;

    // Constructor
    public function __construct($args = [])
    {
        $this->id_evento       = $args['id'] ?? null;

        $this->titulo          = $args['titulo'] ?? '';
        $this->descripcion     = $args['descripcion'] ?? '';

        $this->id_categoria    = $args['id_categoria'] ?? null;
        $this->id_escritor     = $args['id_escritor'] ?? null;
        $this->id_localizacion = $args['id_localizacion'] ?? null;

        $this->fecha = '';
        if (!empty($args['fecha'])) {
            $this->fecha = $this->normalizarFecha($args['fecha']);
        }
    }

    // Me daba errores, así que busqué formas de normalizar una fecha 
    protected function normalizarFecha(string $valor): string {
        $valor = trim($valor);
        // Reemplaza 'T' por espacio si viene de datetime-local
        $valor = str_replace('T', ' ', $valor);
        // Si viene sin segundos añade ':00'
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $valor)) {
            $valor .= ':00';
        }
        return $valor;
    }

    // Getters

    public function getIdEvento(): ?int {
        return $this->id_evento;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function getIdCategoria(): ?int {
        return $this->id_categoria;
    }

    public function getIdEscritor(): ?int {
        return $this->id_escritor;
    }

    public function getIdLocalizacion(): ?int {
        return $this->id_localizacion;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    // Setters

    public function setIdEvento(?int $id): void {
        $this->id_evento = $id;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setIdCategoria(?int $idCategoria): void {
        $this->id_categoria = $idCategoria;
    }

    public function setIdEscritor(?int $idEscritor): void {
        $this->id_escritor = $idEscritor;
    }

    public function setIdLocalizacion(?int $idLocalizacion): void {
        $this->id_localizacion = $idLocalizacion;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    // Validación

    public function validar() {

        if(!$this->titulo) {
            self::$alertas['error'][] = 'El título es obligatorio';
        }

        if(!$this->descripcion) {
            self::$alertas['error'][] = 'La descripción es obligatoria';
        }

        // Se validan las ID de las otras tablas con filter_var que comprueba que sea un número entero y mayor o igual que 1

        if(filter_var($this->id_categoria, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'La categoría es obligatoria y debe ser válida';
        }

        if(filter_var($this->id_escritor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'El escritor es obligatorio y debe ser válido';
        }

        if(filter_var($this->id_localizacion, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'La localización es obligatoria y debe ser válida';
        }

        if(!$this->fecha) {
            self::$alertas['error'][] = 'La fecha es obligatoria';
        } else {
            if (strtotime($this->fecha) === false) {
                self::$alertas['error'][] = 'La fecha no es válida';
            }
        }

        return self::$alertas;
    }
}
