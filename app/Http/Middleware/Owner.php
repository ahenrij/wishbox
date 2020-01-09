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
       if($request->route('wish')) {
           $isOwner = isWishOwner($request->route('wish'));
       }else {
           $isOwner = isBoxOwner($request->route('wishbox'));
       }

       if($isOwner) {
           return $next($request);
       }

       abort(404);
    }
}
