<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use checkDatos;

class ComentarioController extends Controller
{

	public function show($nombre){
       return view('view_Comentario', [
           'comentario' => Comentario::where('nombre', '=', $nombre)->first()
       ]);
   }
   
   //SIRVE PARA GUARDAR NUEVOS COMENTARIOS
    public function guardar(Request $request){
		
       $comentario 	= new Comentario;
	   //--SE VERIFICAN LOS DATOS
	   
	   $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL COMENTARIO
			array(
				"valor" 		=> $request->comentario,
				"regex"			=> $REGEXDESCRIPCION,
				"nombreCampo"	=> "comentario"
		   ),
		   //SE VERIFICA EL VIDEO
		   array(
				"valor" 		=> $request->videoId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "video"
		   ),
		   //SE VERIFICA EL USUARIO
		   array(
				"valor" 		=> $request->usrId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "usuario"
		   ),
		   //SE VERIFICA LA PUNTUACION
		   array(
				"valor" 		=> $request->puntId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "puntuacion"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al Comentario"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Comentario",$camposErr], 201);
		}
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$comentario->comentario = $request->comentario,
			$comentario->stddel 	= 1;
			$comentario->videoId	= $request->videoId;
			$comentario->usrId		= $request->usrId;
			$comentario->puntId		= $request->puntId;
			
			//--SE CREA EL NUEVO Comentario
			$comentario->save();
			
			return response()->json(["success" => "1","msg" => "Comentario registrado"], 201);
			
		}
		
   }
   
	//ACTUALIZA LOS DATOS DE LOS ComentarioS
    public function Actualizar(Request $request, $comId){
		$comentario = new Comentario;
		$comentario = Comentario::find($usrId);
		
		//VERIFICA QUE EL Comentario EXISTA
		if(empty($comentario)){
			return response()->json(["success" => "0","msg" => "El Comentario no existe"], 201);
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
			return response()->json(["success" => "0","msg" => "Error al registrar al Comentario"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Comentario",$camposErr], 201);
		}
		
		if($camposErr === TRUE){
			$comentario->nombre 		= $request->nombre;
			$comentario->contrasena	= $request->contrasena;
			
			//--ACTUALIZA LOS DATOS DEL Comentario
			$comentario->save();
			
			return response()->json(["success" => "1","msg" => "Comentario actualizado"], 201);

		}
   }
   
   	//ELIMINA LOS DATOS DE LOS ComentarioS
    public function Eliminar(Request $request,$usrId){
		$comentario = new Comentario;
		$comentario = Comentario::find($usrId);
		
		//VERIFICA QUE EL Comentario EXISTA
		if(empty($comentario)){
			return response()->json(["success" => "0","msg" => "El Comentario no existe"], 201);
		}else{
			$comentario->stddel		= 0;
			
			//--ACTUALIZA LOS DATOS DEL Comentario
			$comentario->save();
			
			return response()->json(["success" => "1","msg" => "Comentario eliminado"], 201);

		}
   }

}