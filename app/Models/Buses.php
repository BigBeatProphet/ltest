<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buses extends Model{
    use HasFactory;

    protected $fillable = [
        'busname',
    ];

    public function schedules(){
        return $this->hasMany(Schedules::class);
    }
}