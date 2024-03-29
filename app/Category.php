<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function getList()
    {
        return $this->orderBy('id','asc')->pluck('name', 'id');
    }
    protected $fillable = [
        'name'
        ];
}
