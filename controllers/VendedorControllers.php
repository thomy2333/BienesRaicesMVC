<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorControllers{
    public static function crear(Router $router){

        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);
        
            //validar 
            $errores = $vendedor->validar();
        
            //no hay errores
            if(empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router){

        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');

        //obtener los datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //asignar los valores
            $args = $_POST['vendedor'];
            
            //sincronizar el objeto en memoria
            $vendedor->sincronizar($args);
          
            //validacion
            $errores = $vendedor->validar();
          
            if(empty($errores)){
              $vendedor->guardar();
            }
          
          }
          

        $router->render('vendedores/actualizar', [
            'errores'=> $errores,
            'vendedor'=> $vendedor,
        ]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                //validat el tipo a eliminar
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }    
    }
}