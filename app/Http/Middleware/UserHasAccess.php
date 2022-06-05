<?php

namespace App\Http\Middleware;

use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Проверяем, имеет ли доступ юзер к этой странице
        $User = User::findOrFail($request->user_id);
        if(!$User){
            return redirect('/');
        }
        if (!Auth::id()){
            return redirect('login');
        } else {
            if (Auth::id() !== intval($request->user_id)) {
                if (Auth::user()->role !== 'admin') {
                    return redirect('/');
                }
            }
        }
        return $next($request);
    }
}
