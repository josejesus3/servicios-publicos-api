<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class Incident extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'incidents';
    protected $fillable = [ 'title', 'description', 'direction', 'latitude', 'longitude', 'status', 'user_id', 'area_id','resolution_expire' ];
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    protected $casts = [
    'latitude'  => 'double',
    'longitude' => 'double',
];

#[Override]
	protected static function booted()
    {
        static::creating(function($incident){
            $incident->status='pendiente';

        });
    }

    public function user() {
        return $this->belongsTo( User::class );
    }

    public function area() {
        return $this->belongsTo( Area::class );
    }

    public function media() {
        return $this->hasMany( IncidentMedia::class );
    }

    public function resolution() {
        return $this->hasOne( Resolution::class );
        // Un reporte tiene una ( o ninguna ) resolución
    }

}
