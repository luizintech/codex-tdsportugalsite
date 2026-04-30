<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model 
{
    protected $table = "medias";

    protected $fillable = [
        'filename', 
        'path', 
        'slug',
        'altText'
    ];
}