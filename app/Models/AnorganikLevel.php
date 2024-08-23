<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnorganikLevel extends Model
{
    use HasFactory;
    protected $table = 'anorganik_levels';
    protected $fillable = ['distance2'];
}
