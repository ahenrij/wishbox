<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\WishCreateRequest;
use App\Http\Requests\WishUpdateRequest;
use App\User;
use App\Wish;
use App\WishBox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

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
        $type = $this->type();
        $wishBox = WishBox::where('id', session(WISH_BOX_ID))->first();
        $categories = Category::pluck('title', 'id');

        if ($wishBox) {
            return view('wish.create', compact('categories', 'wishBox', 'type'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WishCreateRequest $request)
    {
        $type = $this->type();
        $link = $request->input('link');
        if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {

            return back()->withInput()->withError('L\'URL que vous avez renseigné est invalide');
        }

        $filename = '';
        if ($request->hasFile('filename')) {
            $image = $request->file('filename');
            $filename = 'wish_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/wishes/' . $filename);
            Image::make($image->getRealPath())->resize(350, 350)->save($path);
        }

        $inputs = array_merge($request->all(), compact('filename'));
        $wish = new Wish();
        if ($this->storeWish($wish, $inputs)) {
            return redirect()->route($type.'box.show', $wish->wish_box_id);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement du souhait');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = $this->type();
        $wish = Wish::where('id', $id)->first();
        return view('wish.show', compact('wish', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = $this->type();
        $wish = Wish::where('id', $id)->first();
        $categories = Category::pluck('title', 'id');

        return view('wish.edit', compact('wish', 'categories', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function update(WishUpdateRequest $request, $id)
    {
        $type = $this->type();
        $wish = Wish::where('id', $id)->first();

        $link = $request->input('link');
        if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {

            return back()->withInput()->withError('L\'URL que vous avez renseigné est invalide');
        }

        $filename = $wish->filename;
        if ($request->hasFile('filename')) {
            $image = $request->file('filename');
            $filename = 'wish_' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/wishes/' . $filename);
            Image::make($image->getRealPath())->resize(350, 350)->save($path);

//            Delete old image
            /*if (file_exists(public_path('img/wishes/'.$wish->filename))) {
                @unlink(public_path('img/wishes/'.$wish->filename));
            }*/
        }

        $inputs = array_merge($request->all(), compact('filename'));
        if ($this->storeWish($wish, $inputs)) {
            return redirect()->route($type.'box.show', $wish->wish_box_id);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de la modification du souhait');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = $this->type();
        $wish = Wish::where('id', $id)->first();
        $wishBoxId = $wish->wish_box_id;
        $wish->delete();

        return redirect()->route($type.'box.show', $wishBoxId);
    }

    public function offer(Wish $wish)
    {
        // If current user is the owner or status == 2 || 3, return
        if ($wish->status == WISH_ON_THE_WAY || $wish->status == WISH_RECEIVED) {
            return redirect()->back()->with('error', 'Cadeau déjà offert.');
        }

        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();
        if ($wishBox->user_id == Auth::user()->id) {
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

        if ($offered) {
            // Send mail to both giver and receiver
            $userReceiver = User::where('id', $wishBox->user_id)->first();
            // to giver
            $this->sendMail($userReceiver);

            // to receiver
            $this->sendMail($userReceiver, $isGiver = false);

            return redirect()->route('wishbox.others')->with('success', 'Votre don a été enregistré avec succès. Un mail de confirmation contenant des informations supplémentaires vous a été envoyé à ' . Auth::user()->email);
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
        if ($isGiver) {
            // Send to giver
            // TODO put correct emails
            //Auth::user()->email
            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\EmailWishGiver($user));
        } else {
            //$user->email
            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\EmailWishReceiver(Auth::user()));
        }
    }

    private function storeWish($wish, $inputs)
    {

        $wish->title = $inputs['title'];
        $wish->description = $inputs['description'];
        $wish->link = $inputs['link'];
        if (isset($inputs['filename'])) $wish->filename = $inputs['filename'];
        $wish->priority = $inputs['priority'];
        $wish->status = isset($inputs['status']) ? $inputs['status'] : 0;
        $wish->wish_box_id = $inputs['wish_box_id'];
        $wish->category_id = $inputs['category_id'];

        return $wish->save();
    }

    private function type() {
        return (routeBaseName() == 'wish') ? TYPE_WISH : TYPE_GIFT;
    }
}
