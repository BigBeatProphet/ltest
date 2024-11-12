<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model{
    use HasFactory;

    protected $fillable = [
        'busid',
        'stopid',
        'arrivaltime',
    ];

    public function bus(){
        return $this->belongsTo(Buses::class);
    }

    public function stop(){
        return $this->belongsTo(Stops::class);
    }
}


