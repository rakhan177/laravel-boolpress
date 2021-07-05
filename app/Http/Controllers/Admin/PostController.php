<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view("admin.posts.index", [ "posts" => $posts]);
        // $data = [
        //     'posts' => Post::orderBy("created_at", "DESC")
        //         ->where("user_id", $request->user()->id)
        //         ->get()
        // ];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // //controlliamo i campi inseriti dall' utente con validate: 
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => "nullable|exists:categories,id"
        ]);

        // controllo utente che sta creando il post
        // dump($request->user());
        // return


        // prendiamo i dati
        $form_data = $request->all();
        // istanziamo un nuovo oggetto Post
        $new_post = new Post();
        // inseriamo tutti i dati con fill nel nuovo oggetto
        $new_post->fill($form_data);

        // inseriamo i dati utente che crea il post,non lo lasciamo al fillable per ragioni di sicurezza
        $new_post->user_id = $request->user()->id;

        // assegno il campo titolo come slug con la funzione slug della classe Str, per usarla aggiungo: 
        // use Illuminate\Support\Str;
        $slug = Str::slug($new_post->title);
        $slug_base = $slug;

         // verifico che lo slug non esista nel database
        $post_presente = Post::where('slug', $slug)->first();
        $contatore = 1;

        // se lo slug esiste entro in un while e controllo tutti i post con lo stesso slug aggiungendogli un contatore
        while($post_presente){
            // aggiungo il contatore allo slug
            $slug = $slug_base . '-' . $contatore;
            $contatore++;
            // ricontrollo gli slug
            $post_presente = Post::where('slug', $slug)->first();
        };

        // esco dal ciclo e salvo lo slug nel new_post
        $new_post->slug = $slug;

        // salvo e reindirizzo l' utente
        $new_post->save();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // assegnamo a $user la funzproprietàione del model che ci ritornerà l' utente
        // $user = $post->user;
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // recuperiamo le categorie
        $categories = Category::all();
        // creiamo un array per passare i dati
        $data = [
            'post' => $post,
            'categories' => $categories
        ];
        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }
    public function update(Request $request, Post $post) {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            // se la categoria esiste controlla che l id inserito sia salvato in una tabella
            'category_id' => "nullable|exists:categories,id"
        ]);

        $form_data = $request->all();

        // verifico se il titolo ricevuto dal form è diverso dal vecchio titolo
        if ($form_data['title'] != $post->title) {
            // è stato modificato il titolo => devo modificare anche lo slug
            // genero lo slug
            $slug = Str::slug($form_data['title']);
            $slug_base = $slug;
            // verifico che lo slug non esista nel database
            $post_presente = Post::where('slug', $slug)->first();
            $contatore = 1;
            // entro nel ciclo while se ho trovato un post con lo stesso $slug
            while ($post_presente) {
                // genero un nuovo slug aggiungendo il contatore alla fine
                $slug = $slug_base . '-' . $contatore;
                $contatore++;
                $post_presente = Post::where('slug', $slug)->first();
            }
            // quando esco dal while sono sicuro che lo slug non esiste nel db
            // assegno lo slug al post
            $form_data['slug'] = $slug;
        }

        $post->update($form_data);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
