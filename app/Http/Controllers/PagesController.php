<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = "welcome to laravel";
        return view('pages.index', compact('title'));
    }
    public function about(){
        $title = "welcome to about page of laravel";
        return view('pages.about')->with('title',$title);
    }
    public function services(){
        $data = array(
            'title' => 'welcome to services page of laravel',
            'services' => ['web designing','seo','web developer'],
        );
        return view('pages.services')->with($data);
    }
}
