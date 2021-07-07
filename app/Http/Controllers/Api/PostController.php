<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        //leggiamo i post esistenti: 
        $posts = Post::all();
        //per le api non dobbiamo ritornare una view, utilizziamo il metodo response()->json che convertirà
        // i nostri dati in json
        return response()->json([
            "results" => $posts,
            "matteo" => 'ciao'
        ]);
    }
}
