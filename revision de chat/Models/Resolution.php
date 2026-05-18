<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resolution extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'resolutions';
    protected $fillable = [ 'incident_id', 'document_path', 'observations', 'firmado' ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function incident() {
        return $this->belongsTo( Incident::class );
    }

}
