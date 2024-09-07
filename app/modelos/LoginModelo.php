<?php

// Incluir el archivo de conexión a la base de datos y la configuracion de errores.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/errores.php';

class LoginModelo
{
    public function verificarCredenciales($email, $contrasena)
    {
        $mysqli_conn = connectToDatabase();

        if ($mysqli_conn === null) {
            error_log("Error al conectarse a la base de datos.");
            return false;
        }

        // Preparar la consulta SQL para buscar al usuario por correo electrónico en `users_data`
        $query = "SELECT * FROM users_data WHERE email = ?";
        $stmt = $mysqli_conn->prepare($query);

        if ($stmt === false) {
            error_log("No se pudo preparar la sentencia: " . $mysqli_conn->error);
            return false;
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $resultado = $stmt->get_result();



 





        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            error_log("Usuario encontrado: " . print_r($usuario, true));

            // Preparar la consulta para buscar la contraseña en `users_login`
            $queryLogin = "SELECT contrasena FROM users_login WHERE id_user = ?";
            $stmtLogin = $mysqli_conn->prepare($queryLogin);
            $stmtLogin->bind_param('i', $usuario['id_user']);
            $stmtLogin->execute();
            $resultadoLogin = $stmtLogin->get_result();


        

            
            if ($resultadoLogin->num_rows === 1) {
                $loginData = $resultadoLogin->fetch_assoc();

    // DEPURACIÓN: Verificar la contraseña ingresada y la almacenada
    var_dump($contrasena); // Contraseña ingresada
    var_dump($loginData['contrasena']); // Contraseña almacenada en la base de datos

//------------------------ok -------------//------------------------//------------------------//

                // Verificar la contraseña
                if (password_verify($contrasena, $loginData['contrasena'])) {

                    error_log("Contraseña verificada correctamente para el usuario: " . $usuario['id_user']);
                    return $usuario; // Retornar los datos del usuario si la contraseña es correcta



                } else {


                    //LLEGAMOS A ESTE PUNTO ----------///------/////
                    var_dump("Contraseña incorrecta");  //DEPURACION
                    exit();

                    error_log("Contraseña incorrecta para el usuario: " . $usuario['id_user']);
                }


            } else {
                error_log("No se encontró la contraseña para el usuario: " . $usuario['id_user']);
            }
        } else {
            error_log("Usuario no encontrado con el correo: " . $email);
        }






        // Si las credenciales son incorrectas o el usuario no fue encontrado, retornar false
        return false;
    }
}



