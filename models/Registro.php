<?php

namespace Model;

class Registro extends ActiveRecord {
    protected static $tabla = 'registros';
    protected static $columnasDB = ['id_registros', 'id_usuario', 'id_evento'];
    protected static $idColumn = 'id_registros';

    // Atributos encapsulados
    protected ?int $id_registros = null;
    protected $id_usuario;
    protected $id_evento;

    // Añadidos para evitar que se tinte de rojo en el Controller
    public ?Evento $evento = null;
    public ?Usuario $usuario = null;

    public function __construct($args = [])
    {
        $this->id_registros = $args['id_registros'] ?? null;
        $this->id_usuario   = $args['id_usuario']   ?? null;
        $this->id_evento    = $args['id_evento']    ?? null;
    }

    // Getters

    public function getIdRegistros(): ?int {
        return $this->id_registros;
    }

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getIdEvento() {
        return $this->id_evento;
    }

    // Setters

    public function setIdRegistros(?int $id): void {
        $this->id_registros = $id;
    }

    public function setIdUsuario($idUsuario): void {
        $this->id_usuario = $idUsuario;
    }

    public function setIdEvento($idEvento): void {
        $this->id_evento = $idEvento;
    }

    // Validación
    public function validar() : array
    {
        static::$alertas = [];

        if(!$this->id_usuario || !filter_var($this->id_usuario, FILTER_VALIDATE_INT)) {
            static::$alertas['error'][] = 'Usuario no válido.';
        }
        if(!$this->id_evento || !filter_var($this->id_evento, FILTER_VALIDATE_INT)) {
            static::$alertas['error'][] = 'Debes seleccionar un evento.';
        }

        return static::$alertas;
    }

    // Comprueba si ya existe el registro usuario-evento
    public static function yaRegistrado(int $id_usuario, int $id_evento) : bool
    {
        $sql = "SELECT 1 FROM " . static::$tabla . " 
                WHERE id_usuario = ? AND id_evento = ? LIMIT 1";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param('ii', $id_usuario, $id_evento);
        $stmt->execute();
        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    // Listado de registros de un usuario con datos del evento, con categoría y localización
    public static function porUsuario(int $id_usuario) : array
    {
        $sql = "SELECT 
                    r.id_registros,
                    e.id_evento,
                    e.titulo,
                    e.fecha,
                    c.nombre  AS categoria,
                    l.nombre  AS localizacion
                FROM registros r
                INNER JOIN evento e       ON e.id_evento = r.id_evento
                LEFT  JOIN categorias c   ON c.id_categoria = e.id_categoria
                LEFT  JOIN localizaciones l ON l.id_localizacion = e.id_localizacion
                WHERE r.id_usuario = ?
                ORDER BY e.fecha ASC";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result();

        $lista = [];
        while ($row = $res->fetch_assoc()) {
            $lista[] = $row;
        }
        $stmt->close();
        return $lista;
    }

    // Elimina un registro del usuario
    public static function eliminarDeUsuario(int $id_registros, int $id_usuario) : bool
    {
        $sql = "DELETE FROM ".static::$tabla." WHERE id_registros = ? AND id_usuario = ? LIMIT 1";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param('ii', $id_registros, $id_usuario);
        $ok = $stmt->execute() && ($stmt->affected_rows > 0);
        $stmt->close();
        return $ok;
    }
}
