<?php
require_once __DIR__ . '/../config/config.php';

class CitasModelo
{
    // Función para obtener todos los usuarios para usar el id en obtenercitasporusuario
    public function obtenerUsuarios()
    {
        $conn = connectToDatabase();
        if ($conn === null) {
            return [];
        }

        $sql = "SELECT id_user, nombre FROM users_data";
        $resultado = $conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }
    // Función para obtener las citas de un usuario
    public function obtenerCitasPorUsuario($id_user)
    {
        $conn = connectToDatabase();

        // Verificación de la conexión a la base de datos
        if ($conn === null) {
            die("Error: No se pudo conectar a la base de datos.");
        }

        // Consulta SQL
        $sql = "SELECT citas.*, users_data.nombre 
            FROM citas 
            JOIN users_data ON citas.id_user = users_data.id_user 
            WHERE citas.id_user = ?";

        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die("Error en la consulta: " . $conn->error); // Mostrar error en la consulta SQL
        }

        $stmt->bind_param('i', $id_user);
        $stmt->execute();

        $resultado = $stmt->get_result();

        // Verificar si hay resultados
        if ($resultado && $resultado->num_rows > 0) {
            $citas = $resultado->fetch_all(MYSQLI_ASSOC);
            return $citas;
        } else {
            // No hay citas encontradas
            return [];
        }
    }
    // Función para crear una cita
    public function crearCita($id_user, $fecha_cita, $motivo_cita)
    {
        
        
        $conn = connectToDatabase();
        if ($conn === null) {
            return false;
        }

        $sql = "INSERT INTO citas (id_user, fecha_cita, motivo_cita) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $id_user, $fecha_cita, $motivo_cita);

        return $stmt->execute();
    }    
    // Función para eliminar una cita
    public function eliminarCita($id_cita)
    {
        $conn = connectToDatabase();
        if ($conn === null) {
            return false;
        }

        $sql = "DELETE FROM citas WHERE id_cita = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_cita);

        return $stmt->execute();
    }
    // Función para editar una cita
    public function editarCita($id_cita, $fecha_cita, $motivo_cita)
    {
        $conn = connectToDatabase();
        if ($conn === null) {
            return false;
        }

        $sql = "UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE id_cita = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $fecha_cita, $motivo_cita, $id_cita);

        return $stmt->execute();
    }
}
