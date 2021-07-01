<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //faccio return della home per soli admin
    public function index(){
        return view('admin.home');
    }
}
