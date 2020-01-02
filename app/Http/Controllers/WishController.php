<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Wish;
use App\WishBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wish.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wishBox = WishBox::where('id', session(WISH_BOX_ID))->first();
        $categories = Category::pluck('title', 'id');
        return view('wish.create', compact('wishBoxId', 'categories', 'wishBox'));
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
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wish = Wish::where('id', $id)->first();
        return view('wish.show', compact('wish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function edit(Wish $wish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wish $wish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wish = Wish::where('id', $id)->first();
        $wishBoxId = $wish->wish_box_id;
        $wish->delete();

        return redirect()->route('wishbox.show', $wishBoxId);
    }

    public function offer(Wish $wish)
    {
        // If current user is the owner or status == 2 || 3, return
        if($wish->status == WISH_ON_THE_WAY || $wish->status == WISH_RECEIVED)
        {
            return redirect()->back()->with('error', 'Cadeau déjà offert.');
        }

        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();
        if($wishBox->user_id == Auth::user()->id)
        {
            return redirect()->back()->with('error', 'Vous ne pouvez pas offrir un cadeau dont vous êtes le demandeur.');
        }

        // Processing
        // Set offerer of the wish in the table
        $offered = DB::table('wishes')
            ->where('id', $wish->id)
            ->update([
                'user_id' => Auth::user()->id,
                'status' => WISH_ON_THE_WAY
                ]);

        if($offered)
        {
            // Send mail to both giver and receiver
            $userReceiver = User::where('id', $wishBox->user_id)->first();
            // to giver
            $this->sendMail($userReceiver);

            // to receiver
            $this->sendMail($userReceiver, $isGiver = false);

            return redirect()->route('wishbox.otherWishboxes')->with('success', 'Votre don a été enregistré avec succès. Un mail de confirmation contenant des informations supplémentaires vous a été envoyé à '. Auth::user()->email);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }


    /**
     * @param User $user
     *          The receiver of the gift
     * @param bool $isGiver
     *          Is it a mail for the giver or the receiver ?
     *
     * The authenticated user is the one giving
     */
    public function sendMail(User $user, $isGiver = true)
    {
        // if isGiver, $user contains
        if($isGiver)
        {
            // Send to giver
            // TODO put correct emails
            //Auth::user()->email
            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\EmailWishGiver($user));
        }else {
            //$user->email
            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\EmailWishReceiver(Auth::user()));
        }
    }
}
