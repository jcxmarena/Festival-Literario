<?php

// Se partió de una base y se ha ido modificando para adaptarnos a los requerimientos del sistema
// En algunos casos se ha tenido que hacer comentarios de parámetros para evitar que se tintara de rojo en el apartado correspondiente

namespace Model;

class ActiveRecord {

    // Base de Datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    // Nombre de la columna PK (por defecto 'id'; los modelos pueden sobrescribirla)
    protected static $idColumn = 'id';

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Get y set general

    /**
     * Permite acceder a propiedades protegidas/privadas mediante:
     *   $obj->nombre
     * Primero se intenta localizar un get y un set explícito. Se ha implementado con esta intención para mantener la compatibilidad con el código que
     * ya tengo, evitando reescribir el proyecto. Igualmente se cumple con la encapsulación y tenemos los métodos getter/setter en cada clase
     */
    public function __get(string $propiedad) {

        $metodo = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $propiedad)));

        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        }

        // Si no hay getter, pero la propiedad existe, devolvemos el valor directamente
        if (property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }

        trigger_error("Propiedad '{$propiedad}' no existe en " . static::class, E_USER_NOTICE);
        return null;
    }

    /**
     * Permite asignar a propiedades protegidas/privadas mediante:
     *   $obj->nombre = 'X';
     */
    public function __set(string $propiedad, $valor): void {
        $metodo = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $propiedad)));

        if (method_exists($this, $metodo)) {
            $this->$metodo($valor);
            return;
        }

        // Si no hay setter, pero la propiedad existe, la modificamos directamente
        if (property_exists($this, $propiedad)) {
            $this->$propiedad = $valor;
            return;
        }

        trigger_error("No se puede establecer la propiedad '{$propiedad}' en " . static::class, E_USER_NOTICE);
    }

    // Configuración de la base de datos y alertas
    
    // Configuración DB
    public static function setDB($database) {
        self::$db = $database;
    }

    // Alertas
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Algunas funciones para la base de datos

    // Utilidades SQL Objetos
    public static function consultarSQL($query) {
        $resultado = self::$db->query($query);
        if (!$resultado) return [];

        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    protected static function crearObjeto($registro) {
    $objeto = new static;

    foreach ($registro as $key => $value) {
        if (!property_exists($objeto, $key)) {
            continue;
        }

        $v = $value;

        try {
            $prop = new \ReflectionProperty($objeto, $key);
            $type = $prop->getType();

            if ($type instanceof \ReflectionNamedType) {
                $typeName   = $type->getName();
                $allowsNull = $type->allowsNull();

                if ($typeName === 'int') {
                    if ($v === null) {
                        $v = $allowsNull ? null : 0;
                    } else {
                        $v = (int)$v;
                    }
                } elseif ($typeName === 'float') {
                    if ($v === null) {
                        $v = $allowsNull ? null : 0.0;
                    } else {
                        $v = (float)$v;
                    }
                } elseif ($typeName === 'string') {
                    if ($v === null && !$allowsNull) {
                        $v = '';
                    }
                }
            }
        } catch (\ReflectionException $e) {
            // Si falla reflection, dejamos $v tal cual
        }

        $objeto->$key = $v;
    }

    return $objeto;
}


    // Atributos
    protected function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $col) {
            $atributos[$col] = $this->$col ?? null;
        }
        return $atributos;
    }

    protected function sanitizarAtributos() {
        $atributos = $this->atributos();
        $pk = static::$idColumn;

        if (array_key_exists($pk, $atributos) && is_null($atributos[$pk])) {
            unset($atributos[$pk]);
        }

        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string((string)$value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = []) {
    foreach ($args as $key => $value) {
        if (!in_array($key, static::$columnasDB, true)) {
            continue;
        }

        // Normalizar cadenas: trim
        if (is_string($value)) {
            $value = trim($value);
        }

        // PK vacía => null
        if ($key === static::$idColumn && ($value === '' || $value === null)) {
            $this->$key = null;
            continue;
        }

        // Si la propiedad no existe en el objeto, pasamos
        if (!property_exists($this, $key)) {
            continue;
        }

        // Intentamos adaptar el tipo al de la propiedad tipada
        try {
            $prop = new \ReflectionProperty($this, $key);
            $type = $prop->getType();

            if ($type instanceof \ReflectionNamedType) {
                $typeName   = $type->getName();     // 'int', 'string', etc.
                $allowsNull = $type->allowsNull();  // true si es ?int, ?string...

                // Campos numéricos
                if ($typeName === 'int') {
                    if ($value === '' || $value === null) {
                        $value = $allowsNull ? null : 0;
                    } else {
                        $value = (int)$value;
                    }
                } elseif ($typeName === 'float') {
                    if ($value === '' || $value === null) {
                        $value = $allowsNull ? null : 0.0;
                    } else {
                        $value = (float)$value;
                    }
                }
                // Campos string
                elseif ($typeName === 'string') {
                    // Si alguien pone null, lo forzamos a '' si no permite null
                    if ($value === null && !$allowsNull) {
                        $value = '';
                    }
                }
                // Si necesitas tratar bool u otros tipos, se podrían añadir aquí
            }
        } catch (\ReflectionException $e) {
            // Si algo falla con Reflection, seguimos con asignación "normal"
        }

        $this->$key = $value;
    }
}


    // CRUD

    public function guardar() {
        $pk = static::$idColumn;
        return !is_null($this->$pk) ? $this->actualizar() : $this->crear();
    }

    protected function crear() {
        $atributos = $this->sanitizarAtributos();
        if (empty($atributos)) return false;

        $columnas = implode(', ', array_keys($atributos));
        $valores  = "'" . implode("', '", array_values($atributos)) . "'";

        $query = "INSERT INTO " . static::$tabla . " ($columnas) VALUES ($valores)";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $pk = static::$idColumn;
            $this->$pk = self::$db->insert_id;
        }
        return $resultado;
    }

    protected function actualizar() {
        $pk = static::$idColumn;
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            if ($key === $pk) continue;
            $valores[] = "$key='$value'";
        }

        $query  = "UPDATE " . static::$tabla . " SET " . implode(', ', $valores);
        $query .= " WHERE $pk = '" . self::$db->escape_string((string)$this->$pk) . "' LIMIT 1";

        return self::$db->query($query);
    }

    public function eliminar() {
        $pk = static::$idColumn ?? 'id';
        $query = "DELETE FROM " . static::$tabla .
                 " WHERE {$pk} = '" . self::$db->escape_string((string)$this->$pk) . "' LIMIT 1";
        return self::$db->query($query);
    }

    //Otras consultas

    /** @return static[] */
    public static function all() {
        $pk = static::$idColumn;
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$pk} DESC";
        return self::consultarSQL($query);
    }

    /**
     * Busca por PK y devuelve la instancia concreta o null.
     *
     * @param int|string $id
     */
    public static function find(int|string $id): ?static
    {
        $pk = static::$idColumn;
        $idEsc = self::$db->escape_string((string) $id);

        $query = "SELECT * FROM " . static::$tabla . " WHERE {$pk} = '{$idEsc}' LIMIT 1";
        $resultado = self::consultarSQL($query); // debe devolver array de `static`

        return array_shift($resultado) ?: null; // null si no hay resultados
    }

    // Devuelve hasta $limite registros
    public static function get($limite) {
        $pk = static::$idColumn;
        $lim = (int)$limite;
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$pk} DESC LIMIT {$lim}";
        return self::consultarSQL($query);
    }

    // Busca por columna y valor y devuelve el primer resultado (o null)
    public static function where($columna, $valor) {
        // Seguridad: la columna debe estar en la lista blanca de columnas del modelo
        if (!in_array($columna, static::$columnasDB, true)) {
            return null;
        }
        $valEsc = self::$db->escape_string((string)$valor);
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valEsc}' LIMIT 1";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    /**
     * Retorna todos los registros ordenados por columna.
     *
     * @return static[]
     */
    public static function ordenar(?string $columna, string $orden = 'ASC'): array
    {
        $orden = strtoupper($orden);
        if ($orden !== 'ASC' && $orden !== 'DESC') {
            $orden = 'ASC';
        }

        $pk = static::$idColumn;
        $col = $columna && in_array($columna, static::$columnasDB, true) ? $columna : $pk;

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$col} {$orden}";
        return self::consultarSQL($query);
    }

    /**
     * Retorna registros ordenados con un límite.
     *
     * @return static[]
     */
    public static function ordenarLimite(?string $columna, string $orden = 'ASC', int $limite = 10): array
    {
        $orden = strtoupper($orden);
        if ($orden !== 'ASC' && $orden !== 'DESC') {
            $orden = 'ASC';
        }

        $pk = static::$idColumn;
        $col = $columna && in_array($columna, static::$columnasDB, true) ? $columna : $pk;

        $lim = (int) $limite;
        if ($lim < 1) {
            $lim = 1;
        }

        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$col} {$orden} LIMIT {$lim}";
        return self::consultarSQL($query);
    }

    // Cuenta los registros de una tabla.
    public static function total(?string $columna = null, $valor = null): int
    {
        $query = "SELECT COUNT(*) AS total FROM " . static::$tabla;

        if ($columna !== null && $columna !== '') {
            if (!in_array($columna, static::$columnasDB, true)) {
                return 0;
            }

            if ($valor === null) {
                $query .= " WHERE {$columna} IS NULL";
            } else {
                $valEsc = self::$db->escape_string((string)$valor);
                $query .= " WHERE {$columna} = '{$valEsc}'";
            }
        }

        $resultado = self::$db->query($query);
        if (!$resultado) return 0;

        $fila = $resultado->fetch_assoc();
        return (int)($fila['total'] ?? 0);
    }
}
