<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use checkDatos;

class CategoriaController extends Controller
{

	public function todo(Request $request){
		$categorias = Categoria::all();
			return view('demo1.dist.apps.ecommerce.catalog.add-product',["categorias" => $categorias = Categoria::all()]
		);
	}

   //SIRVE PARA GUARDAR NUEVAS Categoria
    public function guardar(Request $request){
		
       $categoria 	= new Categoria;
	   //--SE VERIFICAN LOS DATOS
	   
		//SI TODO SALE BIEN
		$categoria->videoId 		= session("USR")->_id;
		$categoria->stddel 			= 1;
		$categoria->valor			= $request->nombre;
		
		//--SE CREA EL NUEVO Categoria
		$categoria->save();
		
		return view('demo1.dist.apps.ecommerce.catalog.add-category');
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
		   ),
		   	array(
				"valor" 		=> $request->descripcion,
				"regex"			=> $REGEXDESCRIPCION,
				"nombreCampo"	=> "categoria"
		   )
		));
		
		if($camposErr === TRUE){
			$categoria->videoId 		= session("USR")->_id;;
			$categoria->valor			= $request->valor;
			$categoria->descripcion		= $request->descripcion;
			
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