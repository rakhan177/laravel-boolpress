<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // a molti uso il plurale
    public function posts(){
        return $this->hasMany("App\Post");
    }
}
