<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;
use Carbon\Carbon;

class MemberMiddleware
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
        $user = Auth::user();     
        if ( $user->member == 0 || Carbon::now()->gt( Carbon::parse($user->member_end_time) ) ) {
            return redirect('/mem_intro');
        }
        return $next($request);
    }
}
