<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    //
    public function wishbox() {
        return $this->belongsTo(WishBox::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
