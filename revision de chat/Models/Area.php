<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'areas';
    protected $fillable = [ 'name','slug' ];

    public function users() {
        return $this->hasMaby( User::class );
    }

    public function incidents() {
        return $this->hasMany( Incident::class );
        // Un área tiene muchos reportes asignados
    }
}
