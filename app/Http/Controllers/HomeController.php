<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $pc=new PostsController();
        $posts=$pc->getAll();
       
        if(!Auth::check() )
        {
            return view('/guest', ['posts' => $posts]);
        }
        
        return view('/home', ['posts' => $posts]);
    }
    public function indexCategorized($category)
    {
        $pc=new PostsController();
        $posts=$pc->getAllByCategory($category);
        if(Auth::check())
            return view('/home', ['posts' => $posts]);
        return view('/guest', ['posts' => $posts]);
    }
    
}
