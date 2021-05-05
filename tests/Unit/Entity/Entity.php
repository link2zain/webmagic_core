<?php

namespace Tests\Unit\Entity;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $fillable = ['name', 'description'];
}