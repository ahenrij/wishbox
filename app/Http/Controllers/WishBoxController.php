<?php

namespace App\Http\Controllers;

use App\WishBox;
use Illuminate\Http\Request;

class WishBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wishbox.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WishBox  $wishBox
     * @return \Illuminate\Http\Response
     */
    public function show(WishBox $wishBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishBox  $wishBox
     * @return \Illuminate\Http\Response
     */
    public function edit(WishBox $wishBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WishBox  $wishBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishBox $wishBox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WishBox  $wishBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishBox $wishBox)
    {
        //
    }

    public function giftbox() {
        return view('wishbox.giftbox');
    }
}
