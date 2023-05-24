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
			
			return response()->json(["success" => "1","msg" => "Usuario registrado"], 201);
			
		}
		
   }
   
	//ACTUALIZA LOS DATOS DE LOS USUARIOS
    public function Actualizar(Request $request, $usrId){
		$usuario = new Usuario;
		$usuario = Usuario::find($usrId);
		
		//VERIFICA QUE EL USUARIO EXISTA
		if(empty($usuario)){
			return response()->json(["success" => "0","msg" => "El usuario no existe"], 201);
		}
		
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
		
		if($camposErr === TRUE){
			$usuario->nombre 		= $request->nombre;
			$usuario->contrasena	= $request->contrasena;
			
			//--ACTUALIZA LOS DATOS DEL USUARIO
			$usuario->save();
			
			return response()->json(["success" => "1","msg" => "Usuario actualizado"], 201);

		}
   }
   
   	//ELIMINA LOS DATOS DE LOS USUARIOS
    public function Eliminar(Request $request,$usrId){
		$usuario = new Usuario;
		$usuario = Usuario::find($usrId);
		
		//VERIFICA QUE EL USUARIO EXISTA
		if(empty($usuario)){
			return response()->json(["success" => "0","msg" => "El usuario no existe"], 201);
		}else{
			$usuario->stddel		= 0;
			
			//--ACTUALIZA LOS DATOS DEL USUARIO
			$usuario->save();
			
			return response()->json(["success" => "1","msg" => "Usuario eliminado"], 201);

		}
   }

}