<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stops extends Model{
    use HasFactory;

    protected $fillable = [
        'stopname',
        'location'
    ];

    public function schedules(){
        return $this->hasMany(Schedules::class);
    }

    public function routes(){
        return $this->belongsToMany(Routes::class);
    }
}