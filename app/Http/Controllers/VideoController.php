<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use checkDatos;

class VideoController extends Controller
{

	public function show($nombre){
       return view('view_usuario', [
           'video' => Video::where('nombre', '=', $nombre)->first()
       ]);
   }
   
   //SIRVE PARA GUARDAR NUEVOS USUARIOS
    public function guardar(Request $request){
		
       $video 	= new Video;
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
				"regex"			=> $REGEXPSSWORD,
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
			$video->nombre 		= $request->nombre;
			$video->stddel 		= 1;
			$video->contrasena	= $request->contrasena;
			
			//--SE CREA EL NUEVO USUARIO
			$video->save();
			
			return response()->json(["success" => "1","msg" => "Usuario registrado"], 201);
			
		}
		
   }
   
	//ACTUALIZA LOS DATOS DE LOS VIDEOS
    public function Actualizar(Request $request, $vidId){
		$video = new Video;
		$video = Video::find($vidId);
		
		//VERIFICA QUE EL VIDEO EXISTA
		if(empty($video)){
			return response()->json(["success" => "0","msg" => "El video no existe"], 201);
		}
		
		$camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL NOMBRE
			array(
				"valor" 		=> $request->nombre,
				"regex"			=> "/^[a-zA-Z0-9]{0,20}$/",
				"nombreCampo"	=> "nombre"
		   ),
		   //SE VERIFICA EL URL
		   array(
				"valor" 		=> $request->url,
				"regex"			=> $REGEXURL,
				"nombreCampo"	=> "url"
		   ),
		   //DESCRIPCION
		   array(
				"valor" 		=> $request->descripcion,
				"regex"			=> $REGEXDESCRIPCION,
				"nombreCampo"	=> "descripción"
		   ),
		   //CATEGORIA
		   array(
				"valor" 		=> $request->categoriaId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "categoría"
		   ),
		   //PUNTUACION
		   array(
				"valor" 		=> $request->puntuacionId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "puntuación"
		   ),
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar el video"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar el video",$camposErr], 201);
		}
		
		if($camposErr === TRUE){
			$video->nombre 		= $request->nombre;
			$video->contrasena	= $request->contrasena;
			
			//--ACTUALIZA LOS DATOS DEL USUARIO
			$video->save();
			
			return response()->json(["success" => "1","msg" => "Usuario actualizado"], 201);

		}
   }
   
   	//ELIMINA LOS VIDEOS
    public function Eliminar(Request $request,$vidId){
		$video = new Video;
		
		$camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL NOMBRE
			array(
				"valor" 		=> $request->$vidId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "video"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al eliminar el video"], 201);
		}
		
		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al eliminar el video",$camposErr], 201);
		}
		
		$video = Video::find($vidId);
		
		//VERIFICA QUE EL VIDEO EXISTA
		if(empty($video)){
			return response()->json(["success" => "0","msg" => "El video no existe"], 201);
		}else{
			$video->stddel		= 0;
			
			//--ACTUALIZA LOS DATOS DEL VIDEO
			$video->save();
			
			return response()->json(["success" => "1","msg" => "video eliminado"], 201);

		}
   }

}