<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use checkDatos;

class CategoriaController extends Controller
{

	public function show($nombre){
       return view('view_Categoria', [
           'Categoria' => Categoria::where('nombre', '=', $nombre)->first()
       ]);
   }
   
   //SIRVE PARA GUARDAR NUEVAS Categoria
    public function guardar(Request $request){
		
       $categoria 	= new Categoria;
	   //--SE VERIFICAN LOS DATOS
	   
	   $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL ID DEL VIDEO
			array(
				"valor" 		=> $request->videoId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "video"
		   ),
		   //SE VERIFICA LA CATEGORIA
		   array(
				"valor" 		=> $request->valor,
				"regex"			=> $REGEXDESCRIPCION,
				"nombreCampo"	=> "categoria"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al Categoria"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Categoria",$camposErr], 201);
		}
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$categoria->videoId 		= $request->videoId,
			$categoria->stddel 			= 1;
			$categoria->valor			= $request->valor;
			
			//--SE CREA EL NUEVO Categoria
			$categoria->save();
			
			return response()->json(["success" => "1","msg" => "Categoria registrado"], 201);
			
		}
		
   }
   
	//ACTUALIZA LOS DATOS DE LOS Categoria
    public function Actualizar(Request $request, $catId){
		$categoria = new Categoria;
		$categoria = Categoria::find($catId);
		
		//VERIFICA QUE EL Categoria EXISTA
		if(empty($categoria)){
			return response()->json(["success" => "0","msg" => "El Categoria no existe"], 201);
		}
		
	   $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA EL ID DEL VIDEO
			array(
				"valor" 		=> $request->videoId,
				"regex"			=> $REGEXID,
				"nombreCampo"	=> "video"
		   ),
		   //SE VERIFICA LA CATEGORIA
		   array(
				"valor" 		=> $request->valor,
				"regex"			=> $REGEXDESCRIPCION,
				"nombreCampo"	=> "categoria"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al Categoria"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Categoria",$camposErr], 201);
		}
		
		if($camposErr === TRUE){
			$categoria->videoId 		= $request->videoId,
			$categoria->valor			= $request->valor;
			
			//--ACTUALIZA LOS DATOS DEL Categoria
			$categoria->save();
			
			return response()->json(["success" => "1","msg" => "Categoria actualizado"], 201);

		}
   }
   
   	//ELIMINA LOS DATOS DE LOS Categoria
    public function Eliminar(Request $request,$catId){
		$categoria = new Categoria;
		$categoria = Categoria::find($catId);
		
		//VERIFICA QUE EL Categoria EXISTA
		if(empty($categoria)){
			return response()->json(["success" => "0","msg" => "El Categoria no existe"], 201);
		}else{
			$categoria->stddel		= 0;
			
			//--ACTUALIZA LOS DATOS DEL Categoria
			$categoria->save();
			
			return response()->json(["success" => "1","msg" => "Categoria eliminado"], 201);

		}
   }

}