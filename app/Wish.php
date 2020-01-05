<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    //
    public function wishBox() {
        return $this->belongsTo(WishBox::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return User::where('id', $this->attributes['user_id'])->first();
    }
}
