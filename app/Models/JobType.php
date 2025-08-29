<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // import HasFactory
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // optional, for mass assignment
}
