<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Mensaje extends Model
{
    protected $table = 'mensajes';

	protected $fillable = ['user_id', 'valor'];

	public function user()
	{
	    return $this->belongsTo(User::class, 'user_id');
	}
}
