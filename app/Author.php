<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'pen_name',
    ];

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
