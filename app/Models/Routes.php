<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model{
    use HasFactory;

    protected $fillable = [
        'routename',
        'busid',
        'stops',
    ];
    
    protected $casts = [
        'stops' => 'array',
    ];

    public function bus() {
        return $this->belongsTo(Buses::class);
    }

    public function schedules(){
        return $this->hasMany(Schedules::class);
    }
}