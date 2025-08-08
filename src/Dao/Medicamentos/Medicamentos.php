<?php

namespace Dao\Medicamentos;

use Dao\Table;

class Medicamentos extends Table
{
    public static function getAll()
    {
        $sqlstr = "SELECT id, nombre_usuario, edad, nombre_familiar, email_familiar, telefono_familiar, frecuencia_dosis, comentario FROM recordatorio_medicamentos";
        $params = [];
        return self::obtenerRegistros($sqlstr, $params);
    }

    public static function getById(int $id)
    {
        $sqlstr = "SELECT id, nombre_usuario, edad, nombre_familiar, email_familiar, telefono_familiar, frecuencia_dosis, comentario
                   FROM recordatorio_medicamentos WHERE id = :id LIMIT 1";
        $params = [":id" => $id];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insert(array $data)
    {
        $sqlstr = "INSERT INTO recordatorio_medicamentos
                   (nombre_usuario, edad, nombre_familiar, email_familiar, telefono_familiar, frecuencia_dosis, comentario)
                   VALUES (:nombre_usuario, :edad, :nombre_familiar, :email_familiar, :telefono_familiar, :frecuencia_dosis, :comentario)";
        $params = [
            ":nombre_usuario" => $data["nombre_usuario"],
            ":edad" => $data["edad"],
            ":nombre_familiar" => $data["nombre_familiar"],
            ":email_familiar" => $data["email_familiar"],
            ":telefono_familiar" => $data["telefono_familiar"],
            ":frecuencia_dosis" => $data["frecuencia_dosis"],
            ":comentario" => $data["comentario"],
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function delete(int $id)
    {
        $sqlstr = "DELETE FROM recordatorio_medicamentos WHERE id = :id";
        $params = [":id" => $id];
        return self::executeNonQuery($sqlstr, $params);
    }

    // Si quieres, puedes agregar update, filtros u otros métodos.
}
