<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Status
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
        if(Auth::check() && Auth::user()->status == "غير مفعل")
        {
            return back()->with('error', 'هذا الحساب موجود لكنه غير مفعل الرجاء التواصل مع المسئول');
        }
        return $next($request);
    }
}
