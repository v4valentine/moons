<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use checkDatos;

class UsuarioController extends Controller
{

	public function show($nombre){
       return view('view_usuario', [
           'usuario' => Usuario::where('nombre', '=', $nombre)->first()
       ]);
   }
   
   //SIRVE PARA GUARDAR NUEVOS USUARIOS
    public function guardar(Request $request){
		
       $usuario 	= new Usuario;
	   //--SE VERIFICAN LOS DATOS
	   
	   $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL NOMBRE
			array(
				"valor" 		=> $request->nombre,
				"regex"			=> "/^[a-zA-Z0-9]{0,20}$/",
				"nombreCampo"	=> "nombre"
		   ),
		   //SE VERIFICA LA CONTRASEÑA
		   array(
				"valor" 		=> $request->contrasena,
				"regex"			=> "/^[\S]{0,20}$/",
				"nombreCampo"	=> "contrasena"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al usuario"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al usuario",$camposErr], 201);
		}
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$usuario->nombre 		= $request->nombre;
			$usuario->stddel 		= 1;
			$usuario->contrasena	= $request->contrasena;
			
			//--SE CREA EL NUEVO USUARIO
			$usuario->save();
		}
		
   }

}