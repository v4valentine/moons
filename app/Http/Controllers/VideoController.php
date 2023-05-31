<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Categoria;
use App\Http\Controllers\CategoriaController;
use App\Models\Comentario;
use App\Models\Usuario;
use checkDatos;

class VideoController extends Controller
{

   public function ver(Request $request,$v){

		$comentarios 	= Comentario::where('videoId', '=',$v)->get();
		$video			= Video::find($v);
		$usuarios_pre	= Usuario::all();

		$usuarios_res 	= array();

		foreach ($comentarios as $c) {
			foreach ($usuarios_pre as $u) {
				if($c->usrId == $u->_id){

					$r['nombre'] 	= $u->nombre;
					$r['_id'] 		= $u->_id;

					$usuarios_res[] = $r;

				}
			}
		}

		$propietario		= Usuario::find($video->usuarioId);

		return view('demo1.dist.apps.ecommerce.customers.details', [
			'comentarios' 	=> $comentarios,
			'usuarios'		=> $usuarios_res,
			"video"			=> $video,
			"propietario"	=> $propietario
		]);

	}

   public function todos(){
		$categoria = Categoria::all();
		$videos = Video::all();

		$res	= array();

		foreach ($videos as $key) {
			foreach ($categoria as $key2) {
				if($key->categoriaId == $key2->_id){
					
					$r["_id"] 			= $key->_id;
					$r["nombre"] 		= $key->nombre;
					$r["categoria"] 	= $key2->valor;

					$res[] = (object) $r;

				}
			}
		}

		$res2 = array(
			"data" 				=> $res,
			"recordsTotal"		=> count($res),
			"recordsFiltered"	=> count($res),
			"draw"				=> count($res)
		);

		return json_encode($res2);
	}
   
   //SIRVE PARA GUARDAR NUEVOS USUARIOS
    public function guardar(Request $request){
		
       $video 	= new Video;
	   $cat 	= new CategoriaController();
	   //--SE VERIFICAN LOS DATOS
	   
		$camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL NOMBRE
			array(
				"valor" 		=> $request->nombre,
				"regex"			=> "/^[a-zA-Z0-9\s]{0,20}$/",
				"nombreCampo"	=> "nombre"
		   ),
		   //DESCRIPCION
		   array(
				"valor" 		=> $request->descripcion,
				"regex"			=> checkDatos::REGEXDESCRIPCION,
				"nombreCampo"	=> "descripción"
		   ),

		   
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return $cat->todo();
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return $cat->todo();
		}
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$video->nombre 			= $request->nombre;
			$video->url				= $request->url;
			$video->descripcion		= $request->descripcion;
			$video->usuarioId		= session("USR")->_id;
			$video->categoriaId		= $request->categoria;
			$video->stddel 			= 1;
			
			//--SE CREA EL NUEVO USUARIO
			$video->save();
			
			return $cat->todo();
			
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