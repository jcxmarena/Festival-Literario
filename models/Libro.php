<?php 

namespace Model;

class Libro extends ActiveRecord {
    protected static $tabla = 'libros';
    protected static $columnasDB = ['id_libro', 'titulo', 'anio_publicacion', 'id_escritor', 'id_editorial', 'id_categoria'];
    protected static $idColumn = 'id_libro';

    // Atributos encapsulados
    protected ?int $id_libro = null;
    protected string $titulo = '';
    protected $anio_publicacion;
    protected $id_escritor;
    protected $id_editorial;
    protected $id_categoria;

    // Añadidos para evitar que se tinte de rojo en el Controller
    public ?Categoria $categoria = null;
    public ?Escritor $escritor = null;
    public ?Editorial $editorial = null;

    // Constructor
    public function __construct($args = [])
    {
        $this->id_libro         = $args['id_libro'] ?? null;
        $this->titulo           = trim($args['titulo'] ?? '');
        $this->anio_publicacion = $args['anio_publicacion'] ?? null;
        $this->id_escritor      = $args['id_escritor'] ?? null;
        $this->id_editorial     = $args['id_editorial'] ?? null;
        $this->id_categoria     = $args['id_categoria'] ?? null;
    }

    // Getters

    public function getIdLibro(): ?int {
        return $this->id_libro;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function getAnioPublicacion() {
        return $this->anio_publicacion;
    }

    public function getIdEscritor() {
        return $this->id_escritor;
    }

    public function getIdEditorial() {
        return $this->id_editorial;
    }

    public function getIdCategoria() {
        return $this->id_categoria;
    }

    //Setters
    public function setIdLibro(?int $id): void {
        $this->id_libro = $id;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function setAnioPublicacion($anio): void {
        $this->anio_publicacion = $anio;
    }

    public function setIdEscritor($idEscritor): void {
        $this->id_escritor = $idEscritor;
    }

    public function setIdEditorial($idEditorial): void {
        $this->id_editorial = $idEditorial;
    }

    public function setIdCategoria($idCategoria): void {
        $this->id_categoria = $idCategoria;
    }

    // Validación
    public function validar() {
        self::$alertas = []; 

        if(!$this->titulo) {
            self::$alertas['error'][] = 'El título es obligatorio';
        }

        if($this->anio_publicacion !== null && $this->anio_publicacion !== '') {
            if(filter_var($this->anio_publicacion, FILTER_VALIDATE_INT) === false) {
                self::$alertas['error'][] = 'El año de publicación debe ser un número entero';
            } else {
                $anio = (int) $this->anio_publicacion;
                $min = 1000;
                $max = (int) date('Y');
                if($anio < $min || $anio > $max) {
                    self::$alertas['error'][] = "El año de publicación debe estar entre {$min} y {$max}";
                }
            }
        }

        if(filter_var($this->id_escritor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'El escritor es obligatorio y debe ser válido';
        }

        if(filter_var($this->id_editorial, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'La editorial es obligatoria y debe ser válida';
        }

        if(filter_var($this->id_categoria, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
            self::$alertas['error'][] = 'La categoría es obligatoria y debe ser válida';
        }

        return self::$alertas;
    }
}
