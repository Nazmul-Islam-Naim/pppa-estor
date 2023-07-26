<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use HasFactory;

    protected $table = "theme_settings";
    protected $fillable = [
    	'user_id', 'theme_id'
    ];
}