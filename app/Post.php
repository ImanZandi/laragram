<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['path', 'owner_id'];
    // protected $guarded = [];
}
