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
        $type = $this->type();
        $wishboxes = getWishBoxes(Auth::user()->id, $type, 6);
        $isOwner = true;
        return view('wishbox.index', compact('wishboxes', 'isOwner', 'type'));
    }

    /**
     * Others wish or gift boxes
     */
    public function others()
    {
        $type = $this->type();
        $wishboxes = DB::table('wish_boxes')
            ->join('wishes', 'wishes.wish_box_id', '=', 'wish_boxes.id')
            ->join('users', 'wish_boxes.user_id', '=', 'users.id')
            ->select(DB::raw('count(wishes.id) as total, wish_boxes.*, users.username'), 'users.username as user')
            ->where('wish_boxes.user_id', '!=', Auth::user()->id)
            ->where('type', '=', $type)
            ->where('wish_boxes.visibility', '=', VISIBILITY_PUBLIC)
            ->groupBy('wish_boxes.id')
            ->paginate(6);

        $isOwner = false;

        return view('wishbox.index', compact('wishboxes', 'isOwner', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = $this->type();
        return view('wishbox.create', compact('type'));
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
            return redirect()->route($wishbox->type.'box.show', $wishbox->id);
        } else {
            return redirect()->back()->withError('Une erreur est survenue lors de l\'enregistrement');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param $id (of the WishBox),
     * @param $showPendings
     *         show gifts waiting to be received or others
     * @return \Illuminate\Http\Response
     */
    public function show($id, $showPendings = 0)
    {
//        dd($showPendings);
        $type = $this->type();
        $wishbox = WishBox::where('id', $id)->first();
        $pending = false;
        if($showPendings)
        {
            $wishes = DB::table('wishes')
                ->join('wish_boxes', 'wish_boxes.id', '=', 'wishes.wish_box_id' )
                ->where('wish_boxes.id', '=',  $id)
                ->where('wishes.wish_box_id', '=',  $id)
//                ->where('wish_boxes.user_id', '=',  Auth::user()->id)
                ->where('wishes.status', '=', WISH_ON_THE_WAY)
                ->select('wishes.id', 'wishes.title', 'wishes.description', 'wishes.link', 'wishes.filename', 'wishes.status', 'wishes.category_id', 'wishes.user_id')
                ->paginate(8)
//                ->toSql()
            ;
//            dd($wishes);
            $pending = true;
        }else
        {
            $wishes = DB::table('wishes')
                ->join('wish_boxes', 'wish_boxes.id', '=', 'wishes.wish_box_id' )
                ->where('wishes.wish_box_id', '=',  $id)
                ->where('wishes.status', '!=', WISH_ON_THE_WAY)
                ->select('wishes.id', 'wishes.title', 'wishes.description', 'wishes.link', 'wishes.filename', 'wishes.status', 'wishes.category_id', 'wishes.user_id')
                ->paginate(8)
            ;
        }
        $categories = array();

        foreach ($wishes->unique('category_id') as $wish) {
            $categories[] = Category::where('id', $wish->category_id)->first();
        }
        session([WISH_BOX_ID => $wishbox->id]);
        $isOwner = Auth::user()->id == $wishbox->user_id;

        return view('wishbox.show', compact('wishbox', 'wishes', 'categories', 'type', 'isOwner', 'pending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishBox $wishBox
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = $this->type();
        $wishbox = WishBox::where('id', $id)->first();
        return view('wishbox.edit', compact('wishbox', 'type'));
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
            return redirect()->route($wishbox->type.'box.index');
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

    private function type() {
        return (routeBaseName() == 'wishbox') ? TYPE_WISH : TYPE_GIFT;
    }
}
