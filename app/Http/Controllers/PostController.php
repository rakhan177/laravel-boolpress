<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){ 
        // mando alla index i post per data di creazione
        $data = [
            'posts' => Post::orderBy("created_at", "DESC")->get()
        ];
        return view('posts.index', $data);
    }

    public function show($slug) {
        // selezioni dal model il post al quale corrisponde lo slug
        $post = Post::where('slug', $slug)->first();
        //where specifica la colonna e il valore da cercare,con il first recuperiamo il primo elemento, 
        //altrimenti potremmo usare il get che ci ritorna, se ci sono, un array di elementi.

        //se lo slug non esiste riporto un 404
        if (!$post) {
            abort(404);
        }

        $data = ['post' => $post];

        return view('posts.show', $data);
    }
}
