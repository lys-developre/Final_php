<!-- este enrutador es el que decidira que controlador y que metodos usaremos. -->

<?php

//llamamos a el controlador de los usuarios para que se encargue de la logica de los datos de el formulario.
require_once __DIR__ . '/../controladores/UsuarioControlador.php';

//si el metodo es post y el post es registrarse lo mandamos al controlador de registro con el modelo registrar usuariopara que lo valide sanitize y mande a la base de datos.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrarse'])) {

    //instanciamos ela clase usuario controlador.
    $controlador = new UsuarioControlador();
    //llamamos a el metodo encargado de el registro de la clase usuario controlador.
    $controlador->registrarUsuario();
}

