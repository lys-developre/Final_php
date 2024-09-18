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
    //VALÑIDACION EN LA EDICION DE EL ADMIN
    public function validarEdicionUsuario(&$datos)
    {
        // Array para almacenar los errores.
        $errores = [];

        // Definimos las regex que serán las encargadas de cotejarse con los datos.
        $NOMBRE_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $APELLIDOS_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $USUARIO_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $TELEFONO_REGEX = "/^\+?\d{7,15}$/";
        $FECHA_NACIMIENTO_REGEX = "/^\d{4}-\d{2}-\d{2}$/";
        $DIRECCION_REGEX = "/^.{5,100}$/";
        $SEXO_REGEX = "/^(Masculino|Femenino|Otro)$/";
        $ROL_REGEX = "/^(user|admin)$/";
        $CONTRASENA_REGEX = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,_-])[A-Za-z\d!@#$%^&*.,_-]{4,100}$/";

        // Sanitizamos los datos antes de procesarlos.
        foreach ($datos as $campo => $valor) {
            // Convertimos cada dato a entidades HTML seguras.
            $datos[$campo] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
        }

        // Definimos las validaciones para cada campo del formulario.
        $validaciones = [
            'nombre' => [
                'regex' => $NOMBRE_REGEX,
                'error' => "El nombre debe contener entre 2 y 45 caracteres alfabéticos."
            ],
            'apellidos' => [
                'regex' => $APELLIDOS_REGEX,
                'error' => "Los apellidos deben contener entre 2 y 45 caracteres alfabéticos."
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
                'error' => "El número de teléfono debe contener entre 7 y 15 dígitos."
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
            'rol' => [
                'regex' => $ROL_REGEX,
                'error' => "El rol debe ser 'Usuario' o 'Administrador'."
            ],
            // Validación opcional para la contraseña (solo si se proporciona)
            'contrasena' => [
                'regex' => $CONTRASENA_REGEX,
                'error' => "La contraseña debe contener entre 4 y 100 caracteres, incluyendo al menos una letra mayúscula, un número y un carácter especial.",
                'opcional' => true // Esto indica que el campo es opcional
            ]
        ];

        // Procesamos cada campo según las validaciones definidas.
        foreach ($validaciones as $campo => $validacion) {
            // Verificar si el campo es opcional y está vacío
            if (isset($validacion['opcional']) && $validacion['opcional'] && empty($datos[$campo])) {
                continue; // Si es opcional y está vacío, omitimos la validación
            }

            if (!isset($datos[$campo]) || empty($datos[$campo])) {
                $errores[$campo] = "El campo $campo es obligatorio.";
            } elseif (isset($validacion['regex']) && !preg_match($validacion['regex'], $datos[$campo])) {
                $errores[$campo] = $validacion['error'];
            } elseif (isset($validacion['function']) && !$validacion['function']($datos[$campo])) {
                $errores[$campo] = $validacion['error'];
            } elseif (isset($validacion['chequeo_de_formato']) && !$validacion['chequeo_de_formato']($datos[$campo])) {
                $errores[$campo] = $validacion['error_de_formato'];
            }
        }

        // Devolvemos los errores, si existen.
        return $errores;
    }
    // INSERTAR NUEVOS USUARIOS A LA BASE DE DATOS EN LA TABLA DATA_USER Y DATA_LOGIN --------------
    public function insertarUsuario($datos)
    {
        $mysqli_conn = connectToDatabase();

        try {
            $query = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli_conn->prepare($query);

            if ($stmt === false) {
                throw new Exception('Error al preparar la consulta: ' . $mysqli_conn->error);
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
            return ['success' => $stmt->insert_id]; // Devolver el ID del usuario

        } catch (mysqli_sql_exception $e) {
            // Verificamos si es un error de entrada duplicada
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ['error' => 'usuario_duplicado'];
            } else {
                return ['error' => 'Error al insertar usuario: ' . $e->getMessage()];
            }
        }
    }
    public function insertarLogin($idUsuario, $usuario, $contrasenaHasheada, $rol)
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        try {
            // Verificamos si el nombre de usuario ya está registrado
            $queryCheckUser = "SELECT * FROM users_login WHERE usuario = ?";
            $stmtCheckUser = $mysqli_conn->prepare($queryCheckUser);
            $stmtCheckUser->bind_param('s', $usuario);
            $stmtCheckUser->execute();
            $resultadoCheckUser = $stmtCheckUser->get_result();

            if ($resultadoCheckUser->num_rows > 0) {
                // Si ya existe un usuario con este nombre, devolvemos un error
                return ['error' => 'usuario_duplicado'];
            }

            // Insertar los datos en la tabla users_login
            $query = "INSERT INTO users_login (id_user, contrasena, rol, usuario) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli_conn->prepare($query);
            $stmt->bind_param('isss', $idUsuario, $contrasenaHasheada, $rol, $usuario);

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el usuario en users_login: " . $stmt->error);
            }

            return ['success' => true]; // Inserción exitosa

        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ['error' => 'usuario_duplicado'];
            } else {
                return ['error' => 'Error al crear credenciales de inicio de sesión.'];
            }
        }
    }
    public function insertarUsuarioDesdeAdmin($datos)
    {
        $mysqli_conn = connectToDatabase();

        try {
            // Insertar datos en la tabla users_data
            $query = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli_conn->prepare($query);

            if ($stmt === false) {
                throw new Exception('Error al preparar la consulta: ' . $mysqli_conn->error);
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
            return $stmt->insert_id; // Devolver el ID del usuario recién insertado

        } catch (mysqli_sql_exception $e) {
            // Verificamos si es un error de entrada duplicada
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return false; // Usuario duplicado
            } else {
                return false; // Otro tipo de error
            }
        }
    }
    public function insertarLoginDesdeAdmin($idUsuario, $usuario, $contrasenaHasheada, $rol)
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        try {
            // Verificamos si el nombre de usuario ya está registrado
            $queryCheckUser = "SELECT * FROM users_login WHERE usuario = ?";
            $stmtCheckUser = $mysqli_conn->prepare($queryCheckUser);
            $stmtCheckUser->bind_param('s', $usuario);
            $stmtCheckUser->execute();
            $resultadoCheckUser = $stmtCheckUser->get_result();

            if ($resultadoCheckUser->num_rows > 0) {
                return false; // Usuario duplicado
            }

            // Insertar los datos en la tabla users_login
            $query = "INSERT INTO users_login (id_user, contrasena, rol, usuario) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli_conn->prepare($query);
            $stmt->bind_param('isss', $idUsuario, $contrasenaHasheada, $rol, $usuario);

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar el usuario en users_login: " . $stmt->error);
            }

            return true; // Inserción exitosa

        } catch (mysqli_sql_exception $e) {
            return false; // Otro tipo de error
        }
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
    public function actualizarDatosPersonales($id_user, $nombre, $apellidos, $email, $telefono, $direccion, $fecha_nacimiento, $sexo, $contrasenaHash = null)
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        // Actualizar los datos personales en la tabla 'users_data'
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






        // Si se proporciona una nueva contraseña, actualizamos en la tabla 'users_login'
        if ($contrasenaHash) {


            $stmt = $mysqli_conn->prepare("UPDATE users_login SET contrasena = ? WHERE id_user = ?");
            if (!$stmt) {
                error_log("Error al preparar la consulta de contraseña: " . $mysqli_conn->error);
                return false;
            }


            $stmt->bind_param('si', $contrasenaHash, $id_user);
            if (!$stmt->execute()) {
                error_log("Error al ejecutar la consulta de actualización de contraseña: " . $stmt->error);
                return false;
            }
        }

        return true;
    }
    public function obtenerTodosLosUsuarios()
    {
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        // Consulta para obtener los datos de los usuarios
        $query = "SELECT ud.*, ul.usuario, ul.rol FROM users_data ud
                  INNER JOIN users_login ul ON ud.id_user = ul.id_user";

        $result = $mysqli_conn->query($query);

        if ($result && $result->num_rows > 0) {
            $usuarios = $result->fetch_all(MYSQLI_ASSOC);
            return $usuarios;
        } else {
            return [];
        }
    }    public function actualizarUsuario($datos)
    {
        $mysqli_conn = connectToDatabase();

        // Iniciar una transacción
        $mysqli_conn->begin_transaction();

        try {
            // Actualizar en users_data
            $stmt = $mysqli_conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE id_user = ?");
            $stmt->bind_param('sssssssi', $datos['nombre'], $datos['apellidos'], $datos['email'], $datos['telefono'], $datos['fecha_nacimiento'], $datos['direccion'], $datos['sexo'], $datos['id_user']);
            $stmt->execute();

            // Actualizar en users_login (usuario y rol)
            $stmt = $mysqli_conn->prepare("UPDATE users_login SET usuario = ?, rol = ? WHERE id_user = ?");
            $stmt->bind_param('ssi', $datos['usuario'], $datos['rol'], $datos['id_user']);
            $stmt->execute();

            // Si se proporciona una nueva contraseña, actualizarla
            if (!empty($datos['contrasena'])) {
                $stmt = $mysqli_conn->prepare("UPDATE users_login SET contrasena = ? WHERE id_user = ?");
                $stmt->bind_param('si', $datos['contrasena'], $datos['id_user']);
                $stmt->execute();
            }

            // Confirmar la transacción
            $mysqli_conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $mysqli_conn->rollback();
            error_log("Error al actualizar el usuario: " . $e->getMessage());
            return false;
        }
    }    public function eliminarUsuario($id_user)
    {
        $mysqli_conn = connectToDatabase();


        try {
            // Eliminar de users_login
            $stmt = $mysqli_conn->prepare("DELETE FROM users_login WHERE id_user = ?");
            $stmt->bind_param('i', $id_user);

            if (!$stmt->execute()) {
                error_log("Error al eliminar el usuario: " . $stmt->error);
                return false;
            }

            // Eliminar de users_data
            $stmt = $mysqli_conn->prepare("DELETE FROM users_data WHERE id_user = ?");
            $stmt->bind_param('i', $id_user);

            if (!$stmt->execute()) {
                error_log("Error al eliminar los datos de login: " . $stmt->error);
                return false;
            }

            // Confirmar la transacción
            $mysqli_conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción
            $mysqli_conn->rollback();
            error_log("Error al eliminar el usuario: " . $e->getMessage());
            return false;
        }
    }    public function crearUsuarioDesdeAdmin($nombre, $apellidos, $email, $usuario, $contrasena, $telefono, $fecha_nacimiento, $direccion, $sexo, $rol)
    {
        // Conexión a la base de datos
        $mysqli_conn = connectToDatabase(); // Conectar a la base de datos

        // Encriptar la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Iniciar una transacción para asegurar la integridad de los datos
        $mysqli_conn->begin_transaction();

        try {
            // Insertar en la tabla users_data
            $stmt = $mysqli_conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
            $stmt->execute();

            // Obtener el ID del usuario recién creado
            $id_user = $mysqli_conn->insert_id;

            // Insertar en la tabla users_login
            $stmt = $mysqli_conn->prepare("INSERT INTO users_login (id_user, contrasena, rol, usuario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $id_user, $contrasena_hash, $rol, $usuario);
            $stmt->execute();

            // Confirmar la transacción
            $mysqli_conn->commit();
            return true;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $mysqli_conn->rollback();
            return false;
        }
    }
}
