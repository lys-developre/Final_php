<?php
// Incluimos la ruta al archivo de conexión con la base de datos y a el de configuracion para mostrar errores .
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/errores.php';


//definimos la clase que contendra los metodos de para el controlador de usuarios.
class UsuarioModelo
{

    // VERIFICACIÓN Y SANITIZACIÓN DE LOS DATOS ----------------------------------------------------
    public function validarRegistro(&$datos){  // Uso de '&' para pasar los datos por referencia.

        // Array para almacenar los errores.
        $errores = [];

        // Definimos las regex que serán las encargadas de cotejarse con los datos.
        $NOMBRE_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $CONTRASENA_REGEX = "/^(?=.*[A-Z])(?=.*\d)(?=.*[.,_\-!@#$%^&*])[a-zA-Z\d.,_\-!@#$%^&*]{4,30}$/";
        $APELLIDOS_REGEX = "/^[a-zA-ZÁÉÍÓÚÑáéíóúñ ]{2,45}$/";
        $TELEFONO_REGEX = "/^\+?\d{7,15}$/";
        $FECHA_NACIMIENTO_REGEX = "/^\d{4}-\d{2}-\d{2}$/";
        $DIRECCION_REGEX = "/^.{5,100}$/";
        $SEXO_REGEX = "/^(Masculino|Femenino|Otro)$/";

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
            'correo' => [
                'function' => function ($value) {
                    return filter_var($value, FILTER_VALIDATE_EMAIL);
                },
                'error' => "El formato del correo electrónico no es válido."
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

            //si el campo esta vacio se almacena en valor una cadena vacia sino se almacena el valor de el campo iterado.
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
            $datos['contrasena'] = password_hash($datos['contrasena'], PASSWORD_DEFAULT);
        }

        //retornamos los errores ya que solo si no hay errores insertaremos el usuario en la bd.
        return $errores;
    }

    // INSERTAR NUEVOS USUARIOS A LA BASE DE DATOS -------------------------------------------------
    public function insertarUsuario($datos)
    {

        //creamos la variable de coneccion.
        $mysqli_conn = connectToDatabase();

        //verificamos si la coneccion es nula y si lo es mostramos error.
        if ($mysqli_conn === null) {
            return ['error' => 'Error de conexión a la base de datos.'];
        }

        //creamos la consulta.
        $query = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        //preparamos la consulta que creamos anteriormente.
        $stmt = $mysqli_conn->prepare($query);

        //verificamos si la consulta se pudo preparar con exito o no , si no mostramos error.
        if ($stmt === false) {
            error_log("No se pudo preparar la sentencia: " . $mysqli_conn->error);
            return ['error' => 'Error en la preparación de la consulta.'];
        }

        // Enlazamos los parámetros a la consulta.
        $stmt->bind_param(
            "ssssssss",
            $datos['nombre'],
            $datos['apellidos'],
            $datos['correo'],
            $datos['telefono'],
            $datos['fecha_nacimiento'],
            $datos['direccion'],
            $datos['sexo'],
            $datos['contrasena'] // esta contraseña en este punto ya esta encriptada antes de insertarla en la base de datos.
        );

        //verificamos si se pudo ejecutar la consulta , y si es asi la cerramos y devolvemos true. si no mostramos el errror.
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Error en la ejecución de la sentencia: " . $stmt->error);
            $stmt->close();
            return ['error' => 'Error en la ejecución de la consulta.'];
        }
    }
}
