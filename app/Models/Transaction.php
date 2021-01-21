<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    //eloquent tabel transaction
    protected $fillable = ['title', 'amount', 'time', 'type'];
}
