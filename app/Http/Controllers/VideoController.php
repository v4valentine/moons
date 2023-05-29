<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use checkDatos;

class VideoController extends Controller
{

	public function show($nombre){
       return view('view_usuario', [
           'usuario' => Video::where('nombre', '=', $nombre)->first()
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
				"regex"			=> "/^[a-zA-Z0-9\s]{0,20}$/",
				"nombreCampo"	=> "nombre"
		   ),
		   //SE VERIFICA EL URL
		   array(
				"valor" 		=> $request->url,
				"regex"			=> checkDatos::REGEXDESCRIPCION,
				"nombreCampo"	=> "url"
		   ),
		   //DESCRIPCION
		   array(
				"valor" 		=> $request->descripcion,
				"regex"			=> checkDatos::REGEXDESCRIPCION,
				"nombreCampo"	=> "descripción"
		   ),
		   //CATEGORIA
		   array(
				"valor" 		=> $request->categoriaId,
				"regex"			=> checkDatos::REGEXID,
				"nombreCampo"	=> "categoría"
		   ),
		   //PUNTUACION
		   array(
				"valor" 		=> $request->puntuacionId,
				"regex"			=> checkDatos::REGEXID,
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
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$video->nombre 			= $request->nombre;
			$video->url				= $request->url;
			$video->descripcion		= $request->descripcion;
			$video->categoriaId		= $request->categoriaId;
			$video->puntuacionId	= $request->puntuacionId;
			$video->stddel 			= 1;
			
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
				"regex"			=> checkDatos::REGEXDESCRIPCION,
				"nombreCampo"	=> "url"
		   ),
		   //DESCRIPCION
		   array(
				"valor" 		=> $request->descripcion,
				"regex"			=> checkDatos::REGEXDESCRIPCION,
				"nombreCampo"	=> "descripción"
		   ),
		   //CATEGORIA
		   array(
				"valor" 		=> $request->categoriaId,
				"regex"			=> checkDatos::REGEXID,
				"nombreCampo"	=> "categoría"
		   ),
		   //PUNTUACION
		   array(
				"valor" 		=> $request->puntuacionId,
				"regex"			=> checkDatos::REGEXID,
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
			$video->nombre 			= $request->nombre;
			$video->url				= $request->url;
			$video->descripcion		= $request->descripcion;
			$video->categoriaId		= $request->categoriaId;
			$video->puntuacionId	= $request->puntuacionId;
			
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
				"regex"			=> checkDatos::REGEXID,
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