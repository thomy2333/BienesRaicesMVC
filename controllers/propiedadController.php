<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router){

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;

       $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
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

    public static function actualizar(Router $router){

        $id = validarORedireccionar('/admin');
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        //metodo post para actualizar
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //asignar los atributos
            $args = $_POST['propiedad'];
    
            $propiedad->sincronizar($args);
    
            //validacion
            $errores = $propiedad->validar();
    
            //subida de archivos
    
            //generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true)) .  ".jpg";
    
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $imagen = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            //revisar el arreglo de errores este vacio
            if(empty($errores)){
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    //almacenar la imagen
                    $imagen->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $propiedad->guardar();
            }
        }   

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if ($id) {
                $tipo = $_POST['tipo'];    
                if(validarTipoContenido($tipo)){                                        
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }           
               
            }
        }
    }
}