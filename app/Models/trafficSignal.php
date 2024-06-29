<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trafficSignal extends Model
{
    use HasFactory;

    protected  $table = 'traffic_signal';
    
    protected  $fillable = ['session_id','light_one_sequence','light_two_sequence','light_three_sequence','light_four_sequence','green_light_interval','yellow_light_interval'];

    protected $dates = ['created_at', 'updated_at']; 
}
