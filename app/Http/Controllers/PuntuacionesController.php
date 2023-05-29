<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puntuacion;
use checkDatos;

class PuntuacionesController extends Controller
{

	//RETORNA LA PUNTUACION DEPENDIENDO DEL ID INGRESADO
	public function getPuntuacion($nombre){
        return 'Puntuacion' => Puntuacion::find('nombre', '=', $nombre);
   }
   
   //SIRVE PARA GUARDAR NUEVAS Puntuacion
    public function guardar(Request $request){
		
       $puntuacion 	= new Puntuacion;
	   //--SE VERIFICAN LOS DATOS
	   
	   $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA LA Puntuacion
			array(
				"valor" 		=> $request->tipPuntuacion,
				"regex"			=> "/^[0-9]{0,5}$/",
				"nombreCampo"	=> "Puntuacion"
		   ),
		   //SE VERIFICA LA VIDEO
		   array(
				"valor" 		=> $request->valor,
				"regex"			=> "/^[0-9]{0,5}$/",
				"nombreCampo"	=> "valor"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al Puntuacion"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Puntuacion",$camposErr], 201);
		}
		
		//SI TODO SALE BIEN
		if($camposErr === TRUE){
			$puntuacion->tipPuntuacion 	= $request->tipPuntuacion,
			$puntuacion->stddel 		= 1;
			$puntuacion->valor			= $request->valor;
			
			//--SE CREA EL NUEVO Puntuacion
			$puntuacion->save();
			
			return response()->json(["success" => "1","msg" => "Puntuacion registrado"], 201);
			
		}
		
   }
   
	//ACTUALIZA LOS DATOS DE LOS Puntuacion
    public function Actualizar(Request $request, $puntId){
		$puntuacion = new Puntuacion;
		$puntuacion = Puntuacion::find($puntId);
		
		//VERIFICA QUE EL Puntuacion EXISTA
		if(empty($puntuacion)){
			return response()->json(["success" => "0","msg" => "El Puntuacion no existe"], 201);
		}
		
	    $camposErr 	= checkDatos::verificarDatos(array(
			//SE VERIFICA LA Puntuacion
			array(
				"valor" 		=> $request->tipPuntuacion,
				"regex"			=> "/^[0-9]{0,5}$/",
				"nombreCampo"	=> "Puntuacion"
		   ),
		   //SE VERIFICA LA VIDEO
		   array(
				"valor" 		=> $request->valor,
				"regex"			=> "/^[0-9]{0,5}$/",
				"nombreCampo"	=> "valor"
		   )
		));
		
		//ERROR AL VERIFICAR LOS DATOS
		if($camposErr === FALSE){
			return response()->json(["success" => "0","msg" => "Error al registrar al Puntuacion"], 201);
		}

		//RETORNA LOS CAMPOS CON ERRORES
		if(is_array($camposErr)){
			return response()->json(["success" => "2","msg" => "Error al registrar al Puntuacion",$camposErr], 201);
		}
		
		if($camposErr === TRUE){
			$puntuacion->tipPuntuacion 	= $request->tipPuntuacion,
			$puntuacion->valor			= $request->valor;
			
			//--ACTUALIZA LOS DATOS DEL Puntuacion
			$puntuacion->save();
			
			return response()->json(["success" => "1","msg" => "Puntuacion actualizado"], 201);

		}
   }
   
   	//ELIMINA LOS DATOS DE LOS Puntuacion
    public function Eliminar(Request $request,$puntId){
		$puntuacion = new Puntuacion;
		$puntuacion = Puntuacion::find($puntId);
		
		//VERIFICA QUE EL Puntuacion EXISTA
		if(empty($puntuacion)){
			return response()->json(["success" => "0","msg" => "El Puntuacion no existe"], 201);
		}else{
			$puntuacion->stddel		= 0;
			
			//--ACTUALIZA LOS DATOS DEL Puntuacion
			$puntuacion->save();
			
			return response()->json(["success" => "1","msg" => "Puntuacion eliminado"], 201);

		}
   }

}