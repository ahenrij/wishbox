<?php

namespace App\Http\Controllers;

use App\Wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        DB::enableQueryLog(); // Enable query log


        $wishes = DB::table('wishes')
                    ->join('wish_boxes', 'wish_boxes.id', '=', 'wishes.wish_box_id' )
                    ->join('categories', 'categories.id', '=', 'wishes.category_id')
                    ->select('wish_boxes.title as wishBoxTitle', 'wish_boxes.deadline', 'wishes.description', 'wishes.link', 'wishes.filename', 'categories.title as category')
                    ->where('wish_boxes.type', '!=',  config('app.label_is_gift'))
                    ->where('wish_boxes.visibility', '=', config('app.visibility_everyone'))
                    ->paginate(2, '[*]', 'wishes')
//                    ->get()
        ;

        $categories = DB::table('categories')
                                ->select('id', 'title')
                                ->get();

//        $wishes = DB::table('wish_boxes')
//                    ->join('wishes', 'wish_boxes.id', '=', 'wishes.wish_box_id' )
//                    ->join('wishes', 'wishes.category_id', '=', 'category.id')
//                    ->select('wish_boxes.title', 'wish_boxes.deadline', 'wishes.description', 'wishes.link')
//                    ->where('wish_boxes.type', '!=',  config('app.label_is_gift'))
//                    ->where('wish_boxes.visibility', '=', config('app.visibility_everyone'))->get();
//
//        dump($wishes);
//        die();
//        dd(DB::getQueryLog());

       $gifts = DB::table('wishes')
           ->join('wish_boxes', 'wish_boxes.id', '=', 'wishes.wish_box_id' )
           ->join('categories', 'categories.id', '=', 'wishes.category_id')
           ->select('wish_boxes.title as wishBoxTitle', 'wish_boxes.deadline', 'wishes.description', 'wishes.link', 'wishes.filename', 'categories.title as category')
           ->where('wish_boxes.type', '==',  config('app.label_is_gift'))
           ->where('wish_boxes.visibility', '=', config('app.visibility_everyone'))
           ->paginate(2, '[*]', 'gifts')

//           ->get()
       ;





//        Paginator::setPageName('page_a');
//        $wishes->setPageName('wishes');
//        $gifts->setPageName('gifts');
        return view('home', [
            'wishes' => $wishes,
            'categories' => $categories, // for gifts and wishes
            'gifts' => $gifts
        ]);

//        return view('home');
    }

    public function about() {
        return view('about');
    }
}
