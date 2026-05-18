<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {
    use HasFactory, SoftDeletes;
    protected $table='roles';
    protected $fillable=['name','slug'];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    public function users(){
        return $this->hasMany(User::class);
        
    }

}
