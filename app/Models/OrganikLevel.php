<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganikLevel extends Model
{
    use HasFactory;
    protected $table = 'organik_levels';
    protected $fillable = ['distance1'];
}
