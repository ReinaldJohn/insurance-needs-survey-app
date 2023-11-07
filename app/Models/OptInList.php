<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptInList extends Model
{
    use HasFactory;

    protected $table = 'opt_in';
    protected $guarded = [];
}