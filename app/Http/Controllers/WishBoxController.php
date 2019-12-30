<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishBoxCreateRequest;
use App\Http\Requests\WishBoxUpdateRequest;
use App\Wish;
use App\WishBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $wish_boxes = WishBox::where('user_id', Auth::user()->id)->where('type', TYPE_WISH)->get();
//        var_dump($wish_boxes);
        return view('wishbox.index', compact('wish_boxes'));
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
     * @param id (of the WishBox)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wish_box = WishBox::where('id', $id)->first();
        $wishes = Wish::where('wish_box_id', $id)->get();
//        var_dump($wish_box);die();
        return view('wishbox.show', compact('wish_box', 'wishes'));
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
