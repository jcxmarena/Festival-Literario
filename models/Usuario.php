<?php

// Modelo de Usuario 

namespace Model;

class Usuario extends ActiveRecord {

    // Nombre de la tabla de la base de datos con la que vamos a trabajar
    protected static $tabla = 'usuarios';
    
    // Las columnas de la base de datos
    protected static $columnasDB = ['id_usuario', 'nombre', 'apellidos', 'correo', 'password', 'id_rol'];

    protected static $idColumn = 'id_usuario';

    // Propiedades del objeto. ID se genera solo y el rol por defecto siempre será 2 (usuario)
    protected ?int $id_usuario = null;
    protected string $nombre = '';
    protected string $apellidos = '';
    protected string $correo = '';        
    protected string $password = '';      
    // Solo para comparar en el registro, no está en la base de datos
    protected string $password2 = '';
    protected int $id_rol = 2; // 1=admin, 2=usuario por defecto

    // Constructor que permite construir el usuario. Se hace trim para limpiar espacios
    public function __construct($args = [])
    {
        $this->id_usuario = $args['id_usuario'] ?? $args['id'] ?? null;
        $this->nombre     = trim($args['nombre'] ?? '');
        $this->apellidos  = trim($args['apellidos'] ?? '');
        $this->correo     = trim($args['correo'] ?? '');
        $this->password   = $args['password'] ?? ''; // Puede venir de la base de datos o del formulario. Lo aclaro porque en uno la contraseña tiene hash y en el otro no
        $this->password2  = $args['password2'] ?? '';
        $this->id_rol     = $args['id_rol'] ?? 2;
    }

    // Getters

    public function getIdUsuario(): ?int {
        return $this->id_usuario;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getApellidos(): string {
        return $this->apellidos;
    }

    public function getCorreo(): string {
        return $this->correo;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPassword2(): string {
        return $this->password2;
    }

    public function getIdRol(): int {
        return $this->id_rol;
    }

    // Setters

    public function setIdUsuario(?int $id): void {
        $this->id_usuario = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = trim($nombre);
    }

    public function setApellidos(string $apellidos): void {
        $this->apellidos = trim($apellidos);
    }

    public function setCorreo(string $correo): void {
        $this->correo = trim($correo);
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setPassword2(string $password2): void {
        $this->password2 = $password2;
    }

    public function setIdRol(int $idRol): void {
        $this->id_rol = $idRol;
    }

    // Validar cuenta
    public function validar_cuenta() : array {
        self::$alertas = ['error' => []];

        if(!$this->nombre)     self::$alertas['error'][] = 'El nombre es obligatorio';
        if(!$this->apellidos)  self::$alertas['error'][] = 'Los apellidos son obligatorios';

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } elseif(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        } elseif(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Las contraseñas no coinciden';
        }

        return self::$alertas;
    }

    // Validar login
    public function validarLogin() : array {
        self::$alertas = ['error' => []];

        if(!$this->correo) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        } elseif(!filter_var($this->correo, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alertas;
    }

    // Buscar por correo
    // Busca un registro en la base de datos por correo y devuelve el usuario o null
    public static function findByCorreo(string $correo) : ?self {
        $sql = "SELECT `id_usuario`, `nombre`, `apellidos`, `correo`, `password`, `id_rol`
                FROM `" . static::$tabla . "` WHERE `correo` = ? LIMIT 1";
        $stmt = self::$db->prepare($sql);
        if(!$stmt) return null;
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;

        return $row ? new self($row) : null;
    }

    // Para indicar si ya existe un usuario con el correo actual
    public function existeCorreo(): bool {
        return (bool) self::findByCorreo($this->correo);
    }

    // Comprobamos la contraseña
    public function checkPassword(string $hashBD): bool {
        return password_verify($this->password, $hashBD);
    }

    // Función para reemplazar la contrasela con el hash seguro
    public function hashPassword(): void {
        if($this->password && strlen($this->password) >= 6) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
    }

    // Registrar usuario. Se asegura la contraseña, inserta los datos en  la tabla y devuelve true o false
    public function registrar(): bool {
        $this->hashPassword();

        $sql = "INSERT INTO `" . static::$tabla . "` (`nombre`, `apellidos`, `correo`, `password`, `id_rol`)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$db->prepare($sql);
        if(!$stmt) return false;

        $stmt->bind_param(
            "ssssi", // 4 string y un int
            $this->nombre,
            $this->apellidos,
            $this->correo,
            $this->password, // hash ya aplicado
            $this->id_rol
        );
        return $stmt->execute();
    }
}
