<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ["title", "content", "slug", "category_id"];

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function category(){
        // un post una categoria
        return $this->belongsTo("App\Category");
    }

    //relazione molti a molti scritta quindi al plurale
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
