<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
	
	 protected $fillable = [
        'title', 'description'
    ];
	protected $dates = ['created_at'];
	
	public function comment()
	{
		return $this->hasMany('App\Models\Comment');
	}
	
}
