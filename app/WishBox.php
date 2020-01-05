<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishBox extends Model
{
    //
    public function wishes() {
        return $this->hasMany(Wish::class);
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
