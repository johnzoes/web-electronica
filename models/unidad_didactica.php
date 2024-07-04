<?php
require_once 'database.php';

class UnidadDidactica {
    private static $conexion;

    public static function init() {
        self::$conexion = $GLOBALS['conexion'];
    }

    /**
     * Obtiene todas las unidades didácticas.
     *
     * @return array
     * @throws Exception
     */
    public static function all() {
        $result = self::$conexion->query("SELECT * FROM unidad_didactica");
        if ($result === false) {
            throw new Exception("Error en la consulta: " . self::$conexion->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Encuentra una unidad didáctica por ID.
     *
     * @param int $id
     * @return array|null
     * @throws Exception
     */
    public static function find($id) {
        $stmt = self::$conexion->prepare("SELECT * FROM unidad_didactica WHERE id_unidad_didactica = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva unidad didáctica.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function create($data) {
        $stmt = self::$conexion->prepare("INSERT INTO unidad_didactica (nombre, ciclo) VALUES (?, ?)");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("ss", $data['nombre'], $data['ciclo']);
        return $stmt->execute();
    }

    /**
     * Actualiza una unidad didáctica por ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public static function update($id, $data) {
        $stmt = self::$conexion->prepare("UPDATE unidad_didactica SET nombre = ?, ciclo = ? WHERE id_unidad_didactica = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("ssi", $data['nombre'], $data['ciclo'], $id);
        return $stmt->execute();
    }

    /**
     * Elimina una unidad didáctica por ID.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id) {
        $stmt = self::$conexion->prepare("DELETE FROM unidad_didactica WHERE id_unidad_didactica = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Encuentra unidades didácticas por ciclo.
     *
     * @param string $ciclo
     * @return array
     * @throws Exception
     */
    public static function findUnidadDidacticaByCiclo($ciclo) {
        $stmt = self::$conexion->prepare("SELECT * FROM unidad_didactica WHERE ciclo = ?");
        if ($stmt === false) {
            throw new Exception("Error preparando la consulta: " . self::$conexion->error);
        }
        $stmt->bind_param("s", $ciclo);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

UnidadDidactica::init();