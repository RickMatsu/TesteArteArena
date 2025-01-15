<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Permitir que title e body sejam preenchidos em massa
    protected $fillable = ['id', 'title', 'body'];
}