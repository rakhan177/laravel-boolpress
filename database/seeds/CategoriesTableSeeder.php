<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //creiamo le nostre categorie
        $categories = ['Antipasti', 'Primi', 'Secondi', 'Dolci'];

        //per ogni valore istanziamo una nuova categoria nel model
        foreach($categories as $category){
            $new_category = new Category();
            $new_category->name = $category;
            $new_category->slug = Str::slug($category);
            $new_category->save();
        }
    }
}
