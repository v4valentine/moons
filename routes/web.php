<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ComentarioController;

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

Route::get('/comentario/{comId}/{comentario}/{videoId}/{usrId}', [ComentarioController::class, 'Actualizar']);


//---RETORNA EL LOGIN SI NO SE RETORNA NINGURA URL VALIDA----------------------------------------------------------------------------------
Route::get('/', function () {
	return view('demo1.dist.authentication.layouts.corporate.sign-in');
});

//---INICIA SESION EN EL APLICATIVO---------------------------------------------------------------------------------------------------------
Route::post("/login",[ComentarioController::class, 'login']);
