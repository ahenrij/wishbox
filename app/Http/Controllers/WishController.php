<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Http\Requests\CommentCreateRequest;
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

        // Si c'est un gift, récupérer les commentaires (les intérêts manifestés)
        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();
        if($wishBox == null)
        {
            return back()->withInput()->with('error', 'Boîte à souhait introuvable.');
        }

        $type = $wishBox->type;
        $comments = null;
        if($wishBox->type == TYPE_GIFT)
        {
            $comments = DB::table('comments')
                ->join('wishes', 'wishes.id', '=', 'comments.wish_id' )
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->select('comments.id', 'comments.message', 'comments.date as datePublication', 'users.id as user_id', 'users.username', 'users.profile')
                ->paginate(5, '[*]', 'comments')
//                ->toSql()
                ;

//            dd($comments);
        }

        return view('wish.show', compact('wish', 'comments', 'type'));
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

    public function offerWish(Wish $wish)
    {
        $wishBox = $this->offer($wish, Auth::user()->id, "Vous ne pouvez pas offrir ce cadeau à vous même.", WISH_RECEIVED);

        if ($wishBox != null) {
            // Send mail to both giver and receiver
            $userReceiver = User::where('id', $wishBox->user_id)->first();

            // to giver
            $this->sendMail(Auth::user(), $wish->id, "Vous allez exaucer un souhait !", "emails.wish.giver");

            // to receiver
            $this->sendMail($userReceiver, $wish->id, "Votre souhait va être exaucé !", "emails.wish.receiver");

            return redirect()->route('wishbox.others')->with('success', 'Votre don a été enregistré avec succès. Un mail de confirmation contenant des informations supplémentaires vous a été envoyé à ' . Auth::user()->email);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }

    /**
     * Fonction auxilliaire pour offrir (cadeau ou souhait). Fait les opérations communes
     * aux deux fonctionnalités et renvoie
     *         le wishBox correspondant au wish en question (utile pour les traitements suivants
     * dans les deux fonctions appelantes) si tout se passe bien
     *          null sinon
     *
     * @param Wish $wish
     * @return \Illuminate\Http\RedirectResponse|int
     */
    public function offer(Wish $wish, $user_id, $errorIfSame = "Erreur dans le don.", $status = WISH_ON_THE_WAY)
    {

        // If current user is the owner or status == 2 || 3, return
        if ($wish->status == WISH_ON_THE_WAY || $wish->status == WISH_RECEIVED) {
            return redirect()->back()->with('error', 'Cadeau déjà offert.');
        }

        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();
        if ($wishBox->user_id == Auth::user()->id) {
            return redirect()->back()->with('error', $errorIfSame);
        }

        // Processing
        // Set offerer or receiver of the wish in the table
        $offered = DB::table('wishes')
            ->where('id', $wish->id)
            ->update([
                'user_id' => $user_id,
                'status' => $status
            ]);

        return $offered ? $wishBox : null;
    }

    public function receivedGift(Wish $wish)
    {
        // Controls

        // Déjà validé (reçu) ?
        if($wish->status == WISH_RECEIVED)
        {
            return redirect()->back()->with('error', 'Vous avez déjà marqué ce cadeau comme réceptionné !');
        }

        // Est ce que l'utilisateur qui souhaite valider est bien celui a qui le cadeau était destiné ?
        if($wish->user_id != Auth::user()->id)
        {
            return redirect()->back()->with('error', 'Opération interdite ! Souhait non exaucé !');
        }


        // Processing
        $offered = DB::table('wishes')
            ->where('id', $wish->id)
            ->update([
                'status' => WISH_RECEIVED
            ]);

        // Email notification
        if ($offered) {
            // Send mail to both giver and receiver
            $userGiver = User::where('id', $wish->user_id)->first();

            // to giver
            $this->sendMail($userGiver, $wish->id, "Votre cadeau a été reçu !", "emails.gift.received.giver");

            // to receiver
            $subject = "Vous avez reçu votre cadeau. Nous en sommes ravis !";
            $this->sendMail(Auth::user(), $wish->id, $subject, "emails.gift.received.receiver");

            return redirect()->back()->with('success', 'Opérartion effectuée avec succès.');
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }


    }
    public function receivedWish(Wish $wish)
    {
        // Controls

        // Déjà validé (reçu) ?
        if($wish->status == WISH_RECEIVED)
        {
            return redirect()->back()->with('error', 'Vous avez déjà marqué ce souhait comme réceptionné !');
        }

        // Est ce que quelqu'un avait prévu de le donner ?
        if($wish->user_id == null)
        {
            return redirect()->back()->with('error', 'Opération interdite ! Souhait non exaucé !');
        }
        // Le wish doit appartenir à celui qui marque qu'il l'a reçu
        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();

        if($wishBox != null && $wishBox->user_id != Auth::user()->id)
        {
            return redirect()->back()->with('error', 'Opération interdite !');
        }


        // Processing
        $offered = DB::table('wishes')
            ->where('id', $wish->id)
            ->update([
                'status' => WISH_RECEIVED
            ]);

        // Email notification
        if ($offered) {
            // Send mail to both giver and receiver
            $userGiver = User::where('id', $wish->user_id)->first();

            // to giver
            $this->sendMail($userGiver, $wish->id, "Votre cadeau a été reçu !", "emails.gift.received.giver");

            // to receiver
            $subject = "Vous avez reçu votre cadeau. Nous en sommes ravis !";
            $this->sendMail(Auth::user(), $wish->id, $subject, "emails.gift.received.receiver");

            return redirect()->back()->with('success', 'Opérartion effectuée avec succès.');
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }


    }


    public function offerGift(Wish $wish, $user_id)
    {
//        dd($user_id);

        $wishBox = $this->offer($wish, $user_id, "Vous ne pouvez pas offrir ce cadeau à vous même.", WISH_ON_THE_WAY);

        if ($wishBox != null) {
            // Send mail to both giver and receiver
            $userReceiver = User::where('id', $user_id)->first();

            // to giver
            $this->sendMail(Auth::user(), $wish->id, "Votre plus belle action de cette journée : avoir fait un don !", "emails.gift.giver");

            // to receiver
            $subject = "Vous avez demandé ! " . Auth::user()->username. " vous l'offre !";
            $this->sendMail($userReceiver, $wish->id, $subject, "emails.gift.receiver");

            return redirect()->route('wishbox.others')->with('success', 'Votre don a été enregistré avec succès. Un mail de confirmation contenant des informations supplémentaires vous a été envoyé à ' . Auth::user()->email);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }


    /**
     * Un utilisateur souhaite recevoir un cadeau publié par un autre utilisateur.
     * Il a renseigné un commentaire à envoyer avec sa demande.
     *
     * @param CommentCreateRequest $request
     * @param $wishId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function obtainGift(CommentCreateRequest $request, $wishId)
    {
        $inputs = $request->all();

        $wish = Wish::where('id', $wishId)->first();

        // If current user is the owner or status == 2 || 3, return

        if ($wish->status == WISH_ON_THE_WAY || $wish->status == WISH_RECEIVED) {
            return redirect()->back()->with('error', 'Cadeau déjà offert.');
        }

        $wishBox = WishBox::where('id', $wish->wish_box_id)->first();
        if ($wishBox->user_id == Auth::user()->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas recevoir un cadeau dont vous êtes le donneur.');
        }

        // A déjà demandé à recevoir ?
        $user = DB::table('users')
            ->join('comments', 'comments.user_id', '=', 'users.id' )
            ->join('wishes', 'wishes.id', '=', 'comments.wish_id')
            ->select('users.id')
            ->where('users.id', '=', Auth::user()->id)
            ->where('wishes.id', '=', $wishId)
            ->get()
//            ->toSql()
        ;

//        dd();

        if(isset($user->id))
        {
            return redirect()->back()->with('error', 'Vous avez déjà demandé a recevoir ce cadeau.
                        Si vous ne l\'avez pas encore reçu, vous
                        pouvez contacter le donneur via son adresse mail qui vous a été envoyée à ' . Auth::user()->email . '.');
        }
        // Processing
        // Save comment
        $comment = new Comment();
        $comment->message = $inputs['message'];
        $comment->date = date('Y-m-d H:i:s');
        $comment->user_id = Auth::user()->id;
        $comment->wish_id = $wishId;

        if ($comment->save()) {

            // Send mail to both giver and receiver
            $userGiver = User::where('id', $wishBox->user_id)->first();
            // to giver
            $this->sendMail($userGiver, $wishId, "Nouvel intérêt pour votre don !", "emails.gift.giver");

            // to receiver
            $this->sendMail(Auth::user(), $wishId, "Votre demande pour recevoir un cadeau publié.", "emails.gift.receiver");

            return redirect()->route('giftbox.others')->with('success', 'Votre demande a été enregistrée avec succès. Un mail de confirmation contenant des informations supplémentaires vous a été envoyé à ' . Auth::user()->email);
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement');
        }
    }


    /**
     * @param User $user
     *          The receiver of the gift
     * @param bool $isGiver
     *          Is it a mail for the giver or the receiver ?
     * @param bool $isWish
     *          Is it a mail about a wish made by a user or a gift ?
     *
     * The authenticated user is the one giving (if $aboutAWish == true)
     */
    public function sendMail(User $user, $elementId, $subject, $template)
    {

        Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\SendEmail($user, $elementId, $subject, $template));
//
//        if ($isGiver) {
//            // Send to giver
//            // TODO put correct emails
//            //Auth::user()->email
//
//            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\SendEmail($user, $elementId, $type, $subject));
//        } else {
//            //$user->email
//            Mail::to('kelvardusud@gmail.com')->send(new \App\Mail\EmailReceiver($user, $elementId, $type, $subject));
//        }

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
