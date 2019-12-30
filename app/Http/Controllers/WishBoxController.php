<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\WishBoxCreateRequest;
use App\Http\Requests\WishBoxUpdateRequest;
use App\Wish;
use App\WishBox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishBoxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishboxes = DB::table('wish_boxes')
            ->join('wishes', 'wishes.wish_box_id', '=', 'wish_boxes.id')
            ->select(DB::raw('count(wishes.id) as total, wish_boxes.*'))
            ->where('wish_boxes.user_id', '=', Auth::user()->id)
            ->where('type', '=', TYPE_WISH)
            ->groupBy('wish_boxes.id')
            ->paginate(6);

        return view('wishbox.index', compact('wishboxes'));
    }

    public function usersWishboxes()
    {
        $wishboxes = DB::table('wish_boxes')
            ->join('wishes', 'wishes.wish_box_id', '=', 'wish_boxes.id')
            ->join('users', 'wish_boxes.user_id', '=', 'users.id')
            ->select(DB::raw('count(wishes.id) as total, wish_boxes.*'), 'users.username as user')
            ->where('wish_boxes.user_id', '!=', Auth::user()->id)
            ->where('type', '=', TYPE_WISH)
            ->where('wish_boxes.visibility', '=', VISIBILITY_PUBLIC)
            ->groupBy('wish_boxes.id')
            ->paginate(6);
        return view('wishbox.users_boxes', compact('wishboxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wishbox.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WishBoxCreateRequest $request)
    {
        $inputs = $request->all();

        $wishbox = new WishBox();
        $wishbox->title = $inputs['title'];
        $wishbox->deadline = $inputs['deadline'];
        $wishbox->visibility = $inputs['visibility'];
        $wishbox->type = $inputs['type'];
        $wishbox->user_id = Auth::user()->id;

        if ($wishbox->save()) {
            return redirect()->route('wishbox.show', $wishbox->id);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id (of the WishBox),
     *        $forOwner
     *          Boolean : Is it a show for the owner or for another user ?
     * @return \Illuminate\Http\Response
     */
    public function show($id, $forOwner = true)
    {
        $wishbox = WishBox::where('id', $id)->first();
        $wishes = Wish::where('wish_box_id', $id)->paginate(6);
        $categories = array();

        foreach ($wishes->unique('category_id') as $wish) {
            $categories[] = Category::where('id', $wish->category_id)->first();
        }

        return view('wishbox.show', compact('wishbox', 'wishes', 'categories', 'forOwner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishBox $wishBox
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wishbox = WishBox::where('id', $id)->first();
        return view('wishbox.edit', compact('wishbox'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\WishBox $wishBox
     * @return \Illuminate\Http\Response
     */
    public function update(WishBoxUpdateRequest $request, $id)
    {
        $inputs = $request->all();
        $wishbox = WishBox::where('id', $id)->first();

        $wishbox->title = $inputs['title'];
        $wishbox->deadline = $inputs['deadline'];
        $wishbox->visibility = $inputs['visibility'];
        $wishbox->type = $inputs['type'];

        if ($wishbox->save()) {
            return redirect()->route('wishbox.index');
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WishBox $wishBox
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wishbox = WishBox::where('id', $id)->first();
        $wishbox->delete();

        return redirect()->back();
    }
}
