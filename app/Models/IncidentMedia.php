<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentMedia extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'incident_media';
    protected $fillable = [ 'incident_id', 'file_path', 'file_type' ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function incident() {
        return $this->belongsTo( Incident::class );
    }
}
