<?php

class LoginModelo
{
    private $db;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($mysqli_connection)
    {
        $this->db = $mysqli_connection;
    }

    // Método para obtener al usuario por su nombre de usuario
    public function obtenerUsuarioPorNombre($usuario)
    {
        // Preparar la consulta SQL para obtener los datos del usuario desde la base de datos
        $query = "SELECT ul.id_user, ul.usuario, ul.contrasena, ul.rol 
                  FROM users_login ul
                  WHERE ul.usuario = ?";

        // Preparar la consulta y asociar los parámetros
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Retornar el resultado como un array asociativo
        return $resultado->fetch_assoc();
    }
}
