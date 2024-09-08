<?php

class LoginModelo
{
    private $db;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    // Método para obtener al usuario por su correo electrónico
    public function obtenerUsuarioPorCorreo($email)
    {
        // Preparar la consulta SQL para obtener los datos del usuario desde la base de datos
        $query = "SELECT ud.id_user, ud.email, ul.contrasena, ul.rol 
                  FROM users_data ud 
                  JOIN users_login ul ON ud.id_user = ul.id_user 
                  WHERE ud.email = ?";

        // Preparar la consulta y asociar los parámetros
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Retornar el resultado como un array asociativo
        return $resultado->fetch_assoc();
    }
}
