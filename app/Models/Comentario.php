<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
	//ESTABLECE LA BASE DE DATOS A USAR
	protected $connection = 'moonsdb';
	//COLECCION DE MONGODB A UTILIZAR
	protected $collection = 'comentarios';
	
}
