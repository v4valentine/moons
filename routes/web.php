<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/comentario/{comId}/{comentario}/{videoId}/{usrId}', [ComentarioController::class, 'Actualizar']);

//---INICIA SESION EN EL APLICATIVO---------------------------------------------------------------------------------------------------------
Route::any("/login",[UsuarioController::class, 'login']);
//---CIERRA SESION EN EL APLICATIVO---------------------------------------------------------------------------------------------------------
Route::get("/logout",[UsuarioController::class, 'log_out']);

//---OBTIENE TODOS LOS VIDEOS--------------------------------------------------------------------------------------------------------------------------
Route::post("/videos/todos",[VideoController::class, 'todos']);
//---OBTIENE TODOS LOS VIDEOS--------------------------------------------------------------------------------------------------------------------------
Route::get('/videos/agregar',[CategoriaController::class, 'todo']);

Route::post("/videos/agregar",[VideoController::class, 'guardar']);

Route::get("/videos/ver/{v}",[VideoController::class, 'ver']);

Route::post("/video/comentar",[ComentarioController::class, 'guardar']);

//---INGRESA LAS CATEGORIAS----------------------------------------------------------------------------------
Route::get('/videos/categorias/agregar', function (Request $request) {
	return view('demo1.dist.apps.ecommerce.catalog.add-category');
});

Route::post("/videos/categorias/agregar",[CategoriaController::class, 'guardar']);
//---RETORNA EL LOGIN SI NO SE RETORNA NINGURA URL VALIDA----------------------------------------------------------------------------------

Route::get('/', function (Request $request) {
	
	if(empty($request->session()->exists('USR'))){
		return view('demo1.dist.authentication.layouts.corporate.sign-in');
	}else{
		return view('demo1.dist.apps.ecommerce.catalog.products');
	}
});
