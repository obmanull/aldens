<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    public $timestamps = false;
    public $fillable = ['name', 'parent_id', 'slug'];
}
