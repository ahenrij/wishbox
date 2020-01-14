<?php

namespace App\Http\Middleware;

use Closure;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if($request->route('wish') || $request->route('gift')) {
           $id = $request->route('wish');
           if(!$id) {
               $id = $request->route('gift');
           }
           $isOwner = isWishOwner($id);
       }else {
           $id = $request->route('wishbox');
           if(!$id) {
               $id = $request->route('giftbox');
           }
           $isOwner = isBoxOwner($id);
       }

       if($isOwner) {
           return $next($request);
       }

       abort(403);
    }
}
