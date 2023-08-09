<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router){

        $propiedades = Propiedad::all();
        $resultado = $_GET['resultado'] ?? null;

       $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router){

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);
        
            //SUBIDA DE ARCHIVOS 
            //generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true)) .  ".jpg";

            //setar al imagen
            //realizar un resize a la imagen con itervecion 
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
        

            //validar
            $errores =  $propiedad->validar();      

            //revisar el arreglo de errores este vacio
            if(empty($errores)){
                //crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
                }

                //guarda la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                //guardar en la base de datos
                $propiedad->crear();           
            }

        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }

    public static function actualizar(){
        echo "actua";
    }
}