<?php

namespace app\helpers;

class checkDatos {
	/*--CONSTANTES--------------------------------------------------------------------------------------------------------------------*/

		//EXPRESION REGULAR UTILIZADA PARA VALIDAR LOS ID'S DE LAS COLECCIONES
		static public $REGEXID 			= "/^[a-zA-Z0-9áéíóú´ÁÉÍÓÚ@\.\\\/\-\_\+\*\(\)\s\t\n]{0,500}$/";
		static public $REGEXURL			= "/^[(http(s)?):\/\/(www\.)?a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/";
		static public $REGEXDESCRIPCION	= "/^[a-zA-Z0-9áéíóú´ÁÉÍÓÚ@\.\\\/\-\_\+\*\(\)\s\t\n]{0,500}$/";
		static public $REGEXPSSWORD		= "/^[\S]{0,20}$/";
	/*--------------------------------------------------------------------------------------------------------------------------------*/
	/*--FUNCTIONES--------------------------------------------------------------------------------------------------------------------*/

		//VERIFICA QUE LOS DATOS INGRESADOS CUMPLAN CON LA EXPRESION REGULAR INGRESADA
		//--SE INGRESA
			/*ARRAY[
					"valor"=> 'valor',
					"regex"=> 'expresion regular',
					"nombreCampo"=> 'nombre del campo a verificar'
					]
			*/
		//--SE RETORNAN LOS CAMPOS CON ERRORES
			/*ARRAY[
					"campo1",
					"campo2",
					"campo3",
					...
					]
			*/
		static function verificarDatos($datos){
			//--VERIFICA QUE SEA UN ARREGLO
			if(is_array($datos)){
				
				//--VERIFICA QUE EL ARREGLO NO ESTE NO ESTE VACIO
				if(empty($datos)){
					return false;
				}
				
				//--GUARDA LOS CAMPOS CON ERRORES
				$camposErr = array();
				
				foreach($datos as $key){
					//--VERIFICAR DATOS
					if(!preg_match($key["regex"],$key["valor"])){
						$camposErr[] = $key["nombreCampo"];
					}
				}
				
				//SI HAY CAMPOS CON ERRORES
				if(!empty($camposErr)){
					return $camposErr;
				}else{
				//SI NO HAY CAMPOS CON ERRORES
					return true;
				}
				
			}else{
				return false;
			}
		}
		
	/*-------------------------------------------------------------------------------------------------------------------------------*/

}