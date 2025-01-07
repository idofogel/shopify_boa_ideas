<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastSyncDate extends Model
{
    //represents the last update.changed in the end of the collections scheduled tasks
    use HasFactory;
    protected $fillable = ['change_headline'];
}
