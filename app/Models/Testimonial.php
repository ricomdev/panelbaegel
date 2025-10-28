<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timezone('America/Lima')->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timezone('America/Lima')->format('d-m-Y H:i:s');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
