<?php
// Incluimos la ruta al archivo de conexión con la base de datos y a el de configuracion para mostrar errores .
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/errores.php';


//definimos la clase que contendra los metodos de para el controlador de usuarios.
class UsuarioModelo
{

    // VERIFICACIÓN Y SANITIZACIÓN DE LOS DATOS ----------------------------------------------------
    public function validarRegistro(&$datos)
    {  // Uso de '&' para pasar los datos por referencia.

        // Array para almacenar los errores.
        $errores = [];

        // Definimos las regex que serán las encargadas de cotejarse con los datos.
        $NOMBRE_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";

        $CONTRASENA_REGEX = "/^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,100}$/";

        $APELLIDOS_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $TELEFONO_REGEX = "/^\+?\d{7,15}$/";
        $FECHA_NACIMIENTO_REGEX = "/^\d{4}-\d{2}-\d{2}$/";
        $DIRECCION_REGEX = "/^.{5,100}$/";
        $SEXO_REGEX = "/^(Masculino|Femenino|Otro)$/";
        $USUARIO_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";


        // Sanitizamos los datos antes de procesarlos.
        foreach ($datos as $campo => $valor) {
            //convertimos cada dato a entidades html seguras.
            $datos[$campo] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }

        // definimos nuestro array para que cada campo este asociado con un metodo de vaalidacion y un mensaje de error.
        $validaciones = [
            'nombre' => [
                'regex' => $NOMBRE_REGEX,
                'error' => "El nombre debe contener entre 2 y 45 caracteres alfabéticos y puede incluir un espacio para nombres compuestos."
            ],
            'apellidos' => [
                'regex' => $APELLIDOS_REGEX,
                'error' => "Los apellidos deben contener entre 2 y 45 caracteres alfabéticos y pueden incluir un espacio para apellidos compuestos."
            ],
            'email' => [
                'function' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_EMAIL);
                },
                'error' => "El formato del correo electrónico no es válido."
            ],

            'usuario' => [
                'regex' => $USUARIO_REGEX,
                'error' => "El nombre de usuario debe contener entre 2 y 45 caracteres alfanuméricos."
            ],


            'telefono' => [
                'regex' => $TELEFONO_REGEX,
                'error' => "El número de teléfono debe contener entre 7 y 15 dígitos y puede incluir un prefijo internacional si se necesita."
            ],
            'fecha_nacimiento' => [
                'regex' => $FECHA_NACIMIENTO_REGEX,
                'error' => "La fecha de nacimiento debe estar en el formato AAAA-MM-DD.",
                'chequeo_de_formato' => function ($value) {
                    $fecha = DateTime::createFromFormat('Y-m-d', $value);
                    return $fecha && $fecha->format('Y-m-d') === $value;
                },
                'error_de_formato' => "La fecha de nacimiento no es válida."
            ],

            'direccion' => [
                'regex' => $DIRECCION_REGEX,
                'error' => "La dirección debe contener entre 5 y 100 caracteres."
            ],
            'sexo' => [
                'regex' => $SEXO_REGEX,
                'error' => "El sexo debe ser uno de los siguientes valores: Masculino, Femenino, Otro."
            ],

            'contrasena' => [
                'regex' => $CONTRASENA_REGEX,
                'error' => "La contraseña debe contener entre 4 y 30 caracteres, incluyendo al menos una letra mayúscula, un número y un símbolo."
            ]
        ];


        //iteramos sobre todos campos y sus validaciones.
        foreach ($validaciones as $campo => $validacion) {

            //si el campo esta vacio se almacena en valor una cadena vacia, sino se almacena el valor de el campo iterado.
            $valor = isset($datos[$campo]) ? $datos[$campo] : '';


            //si el campo esta vacio mostramos un error.
            if (empty($valor)) {
                $errores[$campo] = "El campo $campo no puede estar vacío.";
                continue;
            }

            //comprovamos las validaciones por regex y por funciones.
            if (isset($validacion['regex']) && !preg_match($validacion['regex'], $valor)) {
                $errores[$campo] = $validacion['error'];
            }

            if (isset($validacion['function']) && !$validacion['function']($valor)) {
                $errores[$campo] = $validacion['error'];
            }

            if (isset($validacion['chequeo_de_formato']) && !$validacion['chequeo_de_formato']($valor)) {
                $errores[$campo] = $validacion['error_de_formato'];
            }
        }





        // si se paso la validacion de los campos es decir que no hay ningun error encriptamos la contraseña.
        if (empty($errores) && isset($datos['contrasena'])) {

            // Encriptamos la contraseña y la almacenamos nuevamente en el array de datos.
            $datos['contrasenaHasheada'] = password_hash($datos['contrasena'], PASSWORD_BCRYPT);
        }








        //retornamos los errores ya que solo si no hay errores insertaremos el usuario en la bd.
        return $errores;
    }
    // INSERTAR NUEVOS USUARIOS A LA BASE DE DATOS EN LA TABLA DATA_USER Y DATA_LOGIN --------------
    public function insertarUsuario($datos)
    {
        $mysqli_conn = connectToDatabase();

        $query = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli_conn->prepare($query);

        // Verificamos si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            var_dump('Error al preparar la consulta: ' . $mysqli_conn->error);
            exit();
        }

        $stmt->bind_param(
            'sssssss',
            $datos['nombre'],
            $datos['apellidos'],
            $datos['email'],
            $datos['telefono'],
            $datos['fecha_nacimiento'],
            $datos['direccion'],
            $datos['sexo']
        );
        $stmt->execute();

        // Retornar el ID del usuario insertado
        return $stmt->insert_id;
    }
    public function insertarLogin($idUsuario, $usuario, $contrasenaHasheada, $rol)
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        // Verificamos si el usuario ya está registrado en la tabla users_login
        $queryCheck = "SELECT * FROM users_login WHERE id_user = ?";
        $stmtCheck = $mysqli_conn->prepare($queryCheck);
        $stmtCheck->bind_param('i', $idUsuario);
        $stmtCheck->execute();
        $resultadoCheck = $stmtCheck->get_result();


        if ($resultadoCheck->num_rows > 0) {
            // Si ya existe un registro para este id_user, lanzamos un error
            error_log("El usuario con id $idUsuario ya tiene un registro en users_login.");
            return false;
        }





        // Insertar los datos en la tabla users_login (id_user, contrasena, rol, usuario)
        $query = "INSERT INTO users_login (id_user, contrasena, rol, usuario) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli_conn->prepare($query);
        $stmt->bind_param('isss', $idUsuario, $contrasenaHasheada, $rol, $usuario);

        if (!$stmt->execute()) {
            error_log("Error al insertar el usuario en users_login: " . $stmt->error);
            return false;
        }

        return true;
    }


    public function obtenerUsuarioPorId($id_user)
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos
    
        // Consulta para obtener los datos del usuario
        $query = "SELECT ud.*, ul.usuario FROM users_data ud
                  INNER JOIN users_login ul ON ud.id_user = ul.id_user
                  WHERE ud.id_user = ?";
                  
        $stmt = $mysqli_conn->prepare($query);

        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $mysqli_conn->error);
            return null;
        }
    
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
    }
    


    public function actualizarDatosPersonales($id_user, $nombre, $apellidos, $email, $telefono, $direccion, $fecha_nacimiento, $sexo)
{
    $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

    // Consulta para actualizar los datos personales
    $stmt = $mysqli_conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, direccion = ?, fecha_nacimiento = ?, sexo = ? WHERE id_user = ?");
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $mysqli_conn->error);
        return false;
    }

    $stmt->bind_param('sssssssi', $nombre, $apellidos, $email, $telefono, $direccion, $fecha_nacimiento, $sexo, $id_user);
    if (!$stmt->execute()) {
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        return false;
    }

    return true;
}

}
