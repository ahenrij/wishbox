<?php
/**
 * Created by TheFather <ahenrij@gmail.com>.
 * User: HD
 * Date: 23/12/2019
 * Time: 19:25
 */

use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
use \App\Wish;
use \App\WishBox;

define('VISIBILITY_PRIVATE', 'private');
define('VISIBILITY_PUBLIC', 'public');
define('VISIBILITY_PROTECTED', 'protected');


define('N_WISHES', 5000);
define('N_WISHBOXES', 500);

// wish_statuses
define('WISH_JUST_CREATED', 0);
define('WISH_ON_THE_WAY', 2);
define('WISH_RECEIVED', 3);

// Files
define('PROFILE_UPLOAD_FOLDER', 'img/profile_pictures');

$visibilities = array(
    VISIBILITY_PRIVATE => 'Moi uniquement',
    VISIBILITY_PUBLIC => 'Tout le monde',
    VISIBILITY_PROTECTED => 'Mes amis'
);

define('TYPE_WISH', 'wish');
define('TYPE_GIFT', 'gift');

$wish_types = array(
    TYPE_GIFT => 'Cadeau',
    TYPE_WISH => 'Souhait'
);

$wish_priorities = array(
    'top' => 'Important',
    'middle' => 'Moyenne'
);

define('visibilities', $visibilities);
define('wish_types', $wish_types);
define('wish_priorities', $wish_priorities);

define('PROFILE_INFO_TEMPLATE', 'users.profile_infos');
define('PROFILE_EDIT_FORM', 'users.edit');

define('WISH_BOX_ID', 'wish_box_id');

function routeBaseName()
{
    return explode('.', Route::currentRouteName())[0];
}

function getWishBoxes($user_id, $type, $perPage) {
    return DB::table('wish_boxes')
        ->join('wishes', 'wishes.wish_box_id', '=', 'wish_boxes.id')
        ->select(DB::raw('count(wishes.id) as total, wish_boxes.*'))
        ->where('wish_boxes.user_id', '=', $user_id)
        ->where('type', '=', $type)
        ->groupBy('wish_boxes.id')
        ->paginate($perPage);
}

function typeOfWish($id) {
    return Wish::where('id', $id)->first()->wishBox->type;
}

function isWishOwner($wish_id) {
    $wish = Wish::where('id', $wish_id)->first();
    return $wish && $wish->wishBox->user_id == Auth::user()->id;
}

function isBoxOwner($box_id) {
    $box = WishBox::where('id', $box_id)->first();
    return $box && $box->user_id == Auth::user()->id;
}
