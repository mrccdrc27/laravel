<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    protected $fillable = ['name', 'price']; // attributes for each toy
}
