<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorControllers{
    public static function crear(Router $router){

        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function actualizar(){
        echo "actu";
    }
    public static function eliminar(){
        echo "elimi";
    }
}